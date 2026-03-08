<?php
// ─────────────────────────────────────────────
//  Sieć Innowacji – formularz kontaktowy
//  Wysyła maila na adres $TO_EMAIL
// ─────────────────────────────────────────────

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

$TO_EMAIL    = 'ikmarketingpl@gmail.com';
$FROM_DOMAIN = 'siecinnowacji.pl';           // adres nadawcy (noreply@...)
$SUBJECT_PFX = '[Sieć Innowacji] Nowe zgłoszenie';

// ── Tylko POST ──────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
    exit;
}

// ── Odczyt danych JSON lub form-urlencoded ──
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!$data) {
    $data = $_POST; // fallback dla form-urlencoded
}

// ── Sanitize ────────────────────────────────
function clean(string $v): string {
    return htmlspecialchars(strip_tags(trim($v)), ENT_QUOTES, 'UTF-8');
}

$name    = clean($data['name']    ?? '');
$firma   = clean($data['firma']   ?? '');
$email   = clean($data['email']   ?? '');
$szkol   = clean($data['szkol']   ?? '');
$message = clean($data['message'] ?? '');

// ── Walidacja serwerowa (ochrona przed omijaniem JS) ──
$errors = [];
if (!$name)  $errors[] = 'Imię i nazwisko jest wymagane';
if (!$firma) $errors[] = 'Nazwa firmy jest wymagana';
if (!$email) $errors[] = 'Adres e-mail jest wymagany';
if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL))
    $errors[] = 'Niepoprawny format adresu e-mail';

if ($errors) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'errors' => $errors]);
    exit;
}

// ── Treść maila ─────────────────────────────
$subject = $SUBJECT_PFX . ' – ' . $name;

$body  = "Nowe zgłoszenie z formularza kontaktowego na siecinnowacji.pl\n";
$body .= str_repeat('─', 50) . "\n\n";
$body .= "Imię i nazwisko : $name\n";
$body .= "Firma           : $firma\n";
$body .= "E-mail          : $email\n";
$body .= "Szkolenie       : " . ($szkol ?: '(nie wybrano)') . "\n";
$body .= "\nWiadomość:\n$message\n";
$body .= "\n" . str_repeat('─', 50) . "\n";
$body .= "Wysłano: " . date('Y-m-d H:i:s') . "\n";

$headers  = "From: Formularz SI <noreply@$FROM_DOMAIN>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "Content-Transfer-Encoding: 8bit\r\n";

// ── Wysyłka ─────────────────────────────────
$sent = mail($TO_EMAIL, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, $headers);

if ($sent) {
    echo json_encode(['ok' => true, 'message' => 'Wiadomość wysłana']);
} else {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Błąd serwera – spróbuj ponownie lub zadzwoń do nas']);
}
