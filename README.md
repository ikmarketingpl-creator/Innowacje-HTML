# Sieć Innowacji – Pakiet stron www

## Zawartość pakietu

```
siec-innowacji/
├── coming-soon.html   ← Strona "Już wkrótce" (wrzuć jako index.html na serwer)
├── index.html         ← Pełna strona docelowa (włącz gdy szkolenia ruszą)
├── img/               ← Tu wrzuć swoje zdjęcia
│   └── (twoje-zdjecie.jpg)
└── README.md          ← Ten plik
```

---

## Jak uruchomić?

### Faza 1 – Przed startem szkoleń
Wrzuć `coming-soon.html` na serwer jako **`index.html`**.  
Strona zbiera e-maile zainteresowanych i pokazuje zapowiedź.

### Faza 2 – Po starcie szkoleń
Zamień `index.html` (czyli aktualny coming-soon) na **pełną stronę** (`index.html` z tego pakietu).

---

## Co musisz uzupełnić

### W obu plikach:
| Co | Gdzie szukać |
|----|-------------|
| **Twoje zdjęcie** | Sekcja „O mnie" — zastąp placeholder foto |
| **Data pierwszego szkolenia** | Sekcja „Najbliższe szkolenie" |
| **Ceny szkoleń #2–#4** | Karty szkoleń — „Wkrótce" → konkretna cena |

### Dane kontaktowe (już wpisane):
- E-mail: `kontakt@siecinnowacji.pl`
- Telefon: `+48 515 259 569`
- Lokalizacja: `88-400 Żnin`

---

## Technologie
- Czysty HTML + CSS + JavaScript (bez frameworków)
- Czcionki: **Montserrat** (nagłówki) + **Poppins** (treść) — Google Fonts
- Ikony: SVG inline (brak zewnętrznych zależności)
- Wymaga połączenia z internetem (Google Fonts CDN)

## Kolory (CSS variables)
```css
--navy:   #0A192F   /* tło ciemne */
--cyan:   #00B4D8   /* akcent niebieski */
--bright: #64FFDA   /* akcent turkusowy */
```

---

## Kontakt / pomoc
siecinnowacji.pl · kontakt@siecinnowacji.pl
