<template>
  <main class="flex justify-center">
    <div class="flex flex-col items-center">
      <div class="max-w-4xl mx-auto p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-6 text-[var(--color-heading)]">
          {{ ls.t('', 'Neprihlásený používateľ') }}
        </h1>
        <ul class="text-[var(--color-text)] space-y-4">
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('', 'Menu') }}</h2>
            <ul class="ml-4 list-disc">
              <li>
                {{
                  ls.t(
                    '',
                    'Domov - vráti používateľa na hlavnú stránku, kde si môže zadať kód otázky'
                  )
                }}
              </li>
              <li>{{ ls.t('', 'Príručka - príručka na použitie webstránky') }}</li>
              <li>{{ ls.t('', 'Prihlásenie - prihlásenie a registrovanie používateľa') }}</li>
              <li>{{ ls.t('', 'EN - zmena jazyku webstránky na anglický') }}</li>
            </ul>
          </li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('', 'Domov') }}</h2>
            <ul class="ml-4 list-disc">
              <li>{{ ls.t('', 'Zadaním kódu do poľa sa zobrazí otázka s daným kódom') }}</li>
            </ul>
          </li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('', 'Otázka') }}</h2>
            <ul class="ml-4 list-disc">
              <li>{{ ls.t('', 'Výber odpovede, alebo zapísanie krátkého odpovede') }}</li>
              <li>{{ ls.t('', 'Po odpovedaní používateľ vidí výsledky hlasovania') }}</li>
              <li>
                <h3 class="text-xl font-medium">{{ ls.t('', 'Výsledky hlasovania') }}</h3>
                <ul class="ml-4 list-disc">
                  <li>{{ ls.t('', 'Otázka s otvorenou odpoveďou') }}</li>
                  <li>
                    {{
                      ls.t(
                        '',
                        'Tlačidlo WordCloud - vypnutie/zapnutie word cloud-u pre výsledky hlasovania'
                      )
                    }}
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('', 'Prihlásenie') }}</h2>
            <ul class="ml-4 list-disc">
              <li>
                {{
                  ls.t(
                    '',
                    'Prihlásiť sa môže iba zaregistrovaný používateľ zadaním email-u a hesla pre jeho konto'
                  )
                }}
              </li>
              <li>
                {{
                  ls.t('', 'Tlačidlo Zaregistrujte sa prevedie používateľa na registračnú stránku')
                }}
              </li>
            </ul>
          </li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('', 'Registrácia') }}</h2>
            <ul class="ml-4 list-disc">
              <li>{{ ls.t('', 'Zadajte validnú e-mail adresu, meno, priezvisko') }}</li>
              <li>{{ ls.t('', 'Zadajte heslo s minimálnou dĺžkou 8 karakterov') }}</li>
              <li>{{ ls.t('', 'Po stlačení tlačidla Registrovať sa používateľ zaregistruje') }}</li>
            </ul>
          </li>
        </ul>

        <h1 class="text-3xl font-bold mt-8 mb-6 text-[var(--color-heading)]">
          {{ ls.t('', 'Prihlásený používateľ') }}
        </h1>
        <ul class="text-[var(--color-text)] space-y-4">
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('', 'Menu') }}</h2>
            <ul class="ml-4 list-disc">
              <li>
                {{
                  ls.t(
                    '',
                    'Domov - vráti používateľa na hlavnú stránku, kde si môže zadať kód otázky'
                  )
                }}
              </li>
              <li>
                {{
                  ls.t(
                    '',
                    'Otázky - prihlásený používateľ tu vie vytvoriť nové otázky, a upraviť už existujúce'
                  )
                }}
              </li>
              <li>{{ ls.t('', 'Príručka - príručka na použitie webstránky') }}</li>
              <li>{{ ls.t('', 'Meno používateľa - zobrazenie osobných údajov') }}</li>
              <li>{{ ls.t('', 'Odhlásenie - odhlásenie používateľa') }}</li>
              <li>{{ ls.t('', 'EN - zmena jazyku webstránky na anglický') }}</li>
            </ul>
          </li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('', 'Domov') }}</h2>
            <ul class="ml-4 list-disc">
              <li>{{ ls.t('', 'Zadaním kódu do poľa sa zobrazí otázka s daným kódom') }}</li>
            </ul>
          </li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('', 'Otázka') }}</h2>
            <ul class="ml-4 list-disc">
              <li>{{ ls.t('', 'Výber odpovede, alebo zapísanie krátkého odpovede') }}</li>
              <li>{{ ls.t('', 'Po odpovedaní používateľ vidí výsledky hlasovania') }}</li>
              <li>
                <h3 class="text-xl font-medium">{{ ls.t('', 'Výsledky hlasovania') }}</h3>
                <ul class="ml-4 list-disc">
                  <li>{{ ls.t('', 'Otázka s otvorenou odpoveďou') }}</li>
                  <li>
                    {{
                      ls.t(
                        '',
                        'Tlačidlo WordCloud - vypnutie/zapnutie word cloud-u pre výsledky hlasovania'
                      )
                    }}
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('', 'Otázky') }}</h2>
            <ul class="ml-4 list-disc">
              <li>
                <h3 class="text-xl font-medium">{{ ls.t('', 'Vytvorenie otázky') }}</h3>
                <ul class="ml-4 list-disc">
                  <li>
                    {{
                      ls.t(
                        '',
                        'Kliknutím na tlačidlo Vytvoriť novú otázku sa objaví malý panel, kde používateľ si môže napísať otázku'
                      )
                    }}
                  </li>
                  <li>
                    {{
                      ls.t('', 'Pre každú otázku si treba vybrať predmet, pre ktorý patrí otázka')
                    }}
                  </li>
                  <li>
                    {{
                      ls.t(
                        '',
                        'Kliknutím na tlačidlo + a - sa môžu pridať dopredu definované otázky, pre otvorené otázky počet odpovedí musí byť 0'
                      )
                    }}
                  </li>
                  <li>{{ ls.t('', 'Kliknutím na tlačidlo Vytvoriť sa vytvorí nová otázka') }}</li>
                </ul>
              </li>
              <li>
                <h3 class="text-xl font-medium">{{ ls.t('', 'Filtrovanie otázok') }}</h3>
                <ul class="ml-4 list-disc">
                  <li>
                    {{
                      ls.t(
                        '',
                        'Vybraním predmetu z Predmet sa vyfiltrujú otázky podľa daného predmetu'
                      )
                    }}
                  </li>
                </ul>
              </li>
              <li>
                <h3 class="text-xl font-medium">{{ ls.t('', 'Úprava otázok') }}</h3>
                <ul class="ml-4 list-disc">
                  <li>
                    {{
                      ls.t(
                        '',
                        'Kliknutím na otázku sa zobrazí otázka s aktuálnymi a archivovanými odpoveďmi, 5 ciferný kód a QR kód'
                      )
                    }}
                  </li>
                  <li>
                    {{
                      ls.t(
                        '',
                        'Kliknutím na tlačidlo Archivovať otázka sa uzavrie a archivuje sa s poznámkou, ktorý zadá používateľ'
                      )
                    }}
                  </li>
                  <li>
                    {{
                      ls.t(
                        '',
                        'Kliknutím na tlačidlo Duplikovať otázka sa duplikuje s novými kódmi'
                      )
                    }}
                  </li>
                  <li>
                    {{
                      ls.t(
                        '',
                        'Kliknutím na tlačidlo Exportovať otázka sa exportuje ako .json súbor'
                      )
                    }}
                  </li>
                  <li>
                    {{
                      ls.t(
                        '',
                        'Kliknutím na tlačidlo Upraviť sa dá upraviť otázku a predmet otázky'
                      )
                    }}
                  </li>
                  <li>{{ ls.t('', 'Kliknutím na tlačidlo Vymazať otázka sa vymaže') }}</li>
                  <li>
                    {{
                      ls.t(
                        '',
                        'Zapnutím/vypnutím WordCloud tlačidla sa zapne/vypne word cloud pre otázku'
                      )
                    }}
                  </li>
                </ul>
              </li>
              <li>
                <h3 class="text-xl font-medium">{{ ls.t('', 'Exportovanie otázok') }}</h3>
                <ul class="ml-4 list-disc">
                  <li>
                    {{
                      ls.t(
                        '',
                        'Vyfiltrované otázky sa dajú exportovať kliknutím na tlačidlo Exportovať pod výberom predmetu'
                      )
                    }}
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('', 'Meno používateľa') }}</h2>
            <ul class="ml-4 list-disc">
              <li>
                <h3 class="text-xl font-medium">{{ ls.t('', 'Môj profil') }}</h3>
                <ul class="ml-4 list-disc">
                  <li>{{ ls.t('', 'Zobrazenie osobných údajov') }}</li>
                </ul>
              </li>
              <li>
                <h3 class="text-xl font-medium">{{ ls.t('', 'Zmeniť heslo') }}</h3>
                <ul class="ml-4 list-disc">
                  <li>
                    {{
                      ls.t(
                        '',
                        'Zadaním starého hesla a dvakrát nového hesla používateľ si môže zmeniť heslo'
                      )
                    }}
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('', 'Odhlásenie') }}</h2>
            <ul class="ml-4 list-disc">
              <li>{{ ls.t('', 'Kliknutím na tlačidlo Odhlásenie používateľ sa odhlási') }}</li>
            </ul>
          </li>
        </ul>

        <h1 class="text-3xl font-bold mt-8 mb-6 text-[var(--color-heading)]">
          {{ ls.t('', 'Administrátor') }}
        </h1>
        <ul class="text-[var(--color-text)] space-y-4">
          <li>
            {{
              ls.t(
                '',
                'Všetky funkcionality prihláseného používateľa plus (preto budú napísané iba nové funkcionality)'
              )
            }}
          </li>
          <li>{{ ls.t('', 'Prístup všetkým otázkám') }}</li>
          <li>{{ ls.t('', 'Vytvorenie otázok v mene iného používateľa') }}</li>
          <li>{{ ls.t('', 'Správa používateľov') }}</li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('', 'Menu') }}</h2>
            <ul class="ml-4 list-disc">
              <li>{{ ls.t('', 'Používateľia - Správa používateľov') }}</li>
            </ul>
          </li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('', 'Otázky') }}</h2>
            <ul class="ml-4 list-disc">
              <li>
                <h3 class="text-xl font-medium">{{ ls.t('', 'Vytvorenie otázky') }}</h3>
                <ul class="ml-4 list-disc">
                  <li>
                    {{
                      ls.t(
                        '',
                        'Tak isto ako prihlásený používateľ plus si musí vybrať používateľa, pre ktorého vytvára otázku'
                      )
                    }}
                  </li>
                </ul>
              </li>
              <li>
                <h3 class="text-xl font-medium">{{ ls.t('', 'Filtrovanie otázok') }}</h3>
                <ul class="ml-4 list-disc">
                  <li>
                    {{
                      ls.t(
                        '',
                        'Vybraním predmetu z Predmet a používateľa z Používateľ sa vyfiltrujú otázky podľa daného predmetu a používateľa'
                      )
                    }}
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('', 'Používateľia') }}</h2>
            <ul class="ml-4 list-disc">
              <li>
                {{
                  ls.t(
                    '',
                    'Tabuľka používateľov, kde je vidno Meno, Priezvisko, E-mail a Rola používateľa'
                  )
                }}
              </li>
              <li>{{ ls.t('', 'Odstránenie používateľa') }}</li>
              <li>
                {{ ls.t('', 'Kliknutím na tlačidlo so symbolom smetiaka sa vymaže používateľ') }}
              </li>
              <li>{{ ls.t('', 'Úprava používateľa') }}</li>
              <li>
                {{
                  ls.t(
                    '',
                    'Kliknutím na tlačidlo so symbolom ceruzky sa otvorí stránka úpravy používateľa'
                  )
                }}
              </li>
              <li>
                {{
                  ls.t('', 'Administrátor môže upraviť email, meno, priezvisko, rolu používateľa')
                }}
              </li>
              <li>{{ ls.t('', 'Pre uloženie zmien treba stlačiť tlačidlo Uložiť') }}</li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </main>
</template>

<script setup>
import { useLanguageStore } from '@/stores/language'
const ls = useLanguageStore()
</script>
