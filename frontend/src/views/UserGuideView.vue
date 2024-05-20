<template>
  <main class="flex justify-center">
    <div class="flex flex-col items-center">
      <div class="max-w-4xl mx-auto p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-6 text-[var(--color-heading)]">
          {{ ls.t('Guest', 'Neprihlásený používateľ') }}
        </h1>
        <ul class="text-[var(--color-text)] space-y-4">
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('Menu', 'Menu') }}</h2>
            <ul class="ml-4 list-disc">
              <li>
                {{
                  ls.t(
                    'Home - returns the user to the main page where they can enter the query code',
                    'Domov - vráti používateľa na hlavnú stránku, kde si môže zadať kód otázky'
                  )
                }}
              </li>
              <li>
                {{
                  ls.t(
                    'Guide - guide to using the website',
                    'Príručka - príručka na použitie webstránky'
                  )
                }}
              </li>
              <li>
                {{
                  ls.t(
                    'Login - user login and registration',
                    'Prihlásenie - prihlásenie a registrovanie používateľa'
                  )
                }}
              </li>
              <li>
                {{
                  ls.t(
                    'SK - change the language of the website to slovak',
                    'EN - zmena jazyku webstránky na anglický'
                  )
                }}
              </li>
            </ul>
          </li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('Home', 'Domov') }}</h2>
            <ul class="ml-4 list-disc">
              <li>
                {{
                  ls.t(
                    'Entering a code in the field will display a question with that code',
                    'Zadaním kódu do poľa sa zobrazí otázka s daným kódom'
                  )
                }}
              </li>
            </ul>
          </li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('Question', 'Otázka') }}</h2>
            <ul class="ml-4 list-disc">
              <li>
                {{
                  ls.t(
                    'Selecting an answer or writing down a short answer',
                    'Výber odpovede, alebo zapísanie krátkého odpovede'
                  )
                }}
              </li>
              <li>
                {{
                  ls.t(
                    'After answering, the user sees the results of the poll',
                    'Po odpovedaní používateľ vidí výsledky hlasovania'
                  )
                }}
              </li>
              <li>
                <h3 class="text-xl font-medium">
                  {{ ls.t('Voting results', 'Výsledky hlasovania') }}
                </h3>
                <ul class="ml-4 list-disc">
                  <li>{{ ls.t('Open-ended question', 'Otázka s otvorenou odpoveďou') }}</li>
                  <li>
                    {{
                      ls.t(
                        'WordCloud button - turn off/on word cloud for voting results',
                        'Tlačidlo WordCloud - vypnutie/zapnutie word cloud-u pre výsledky hlasovania'
                      )
                    }}
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('Log in', 'Prihlásenie') }}</h2>
            <ul class="ml-4 list-disc">
              <li>
                {{
                  ls.t(
                    'Only registered users can log in by entering the email and password for their account',
                    'Prihlásiť sa môže iba zaregistrovaný používateľ zadaním email-u a hesla pre jeho konto'
                  )
                }}
              </li>
              <li>
                {{
                  ls.t(
                    'The Register button takes the user to the registration page',
                    'Tlačidlo Zaregistrujte sa prevedie používateľa na registračnú stránku'
                  )
                }}
              </li>
            </ul>
          </li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('Sign up', 'Registrácia') }}</h2>
            <ul class="ml-4 list-disc">
              <li>
                {{
                  ls.t(
                    'Enter a valid e-mail address, first name, last name',
                    'Zadajte validnú e-mail adresu, meno, priezvisko'
                  )
                }}
              </li>
              <li>
                {{
                  ls.t(
                    'Enter a password with a minimum length of 8 characters',
                    'Zadajte heslo s minimálnou dĺžkou 8 karakterov'
                  )
                }}
              </li>
              <li>
                {{
                  ls.t(
                    'After pressing the Register button, the user registers',
                    'Po stlačení tlačidla Registrovať sa používateľ zaregistruje'
                  )
                }}
              </li>
            </ul>
          </li>
        </ul>

        <h1 class="text-3xl font-bold mt-8 mb-6 text-[var(--color-heading)]">
          {{ ls.t('Logged in user', 'Prihlásený používateľ') }}
        </h1>
        <ul class="text-[var(--color-text)] space-y-4">
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('', 'Menu') }}</h2>
            <ul class="ml-4 list-disc">
              <li>
                {{
                  ls.t(
                    'Home - returns the user to the main page where they can enter the query code',
                    'Domov - vráti používateľa na hlavnú stránku, kde si môže zadať kód otázky'
                  )
                }}
              </li>
              <li>
                {{
                  ls.t(
                    'Questions - a logged in user can create new questions here, and edit existing ones',
                    'Otázky - prihlásený používateľ tu vie vytvoriť nové otázky, a upraviť už existujúce'
                  )
                }}
              </li>
              <li>
                {{
                  ls.t(
                    'Guide - guide to using the website',
                    'Príručka - príručka na použitie webstránky'
                  )
                }}
              </li>
              <li>
                {{
                  ls.t(
                    'User name - view personal data',
                    'Meno používateľa - zobrazenie osobných údajov'
                  )
                }}
              </li>
              <li>{{ ls.t('Logout - user logout', 'Odhlásenie - odhlásenie používateľa') }}</li>
              <li>
                {{
                  ls.t(
                    'SK - change the language of the website to slovak',
                    'EN - zmena jazyku webstránky na anglický'
                  )
                }}
              </li>
            </ul>
          </li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('Home', 'Domov') }}</h2>
            <ul class="ml-4 list-disc">
              <li>
                {{
                  ls.t(
                    'Entering a code in the field will display a question with that code',
                    'Zadaním kódu do poľa sa zobrazí otázka s daným kódom'
                  )
                }}
              </li>
            </ul>
          </li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('Question', 'Otázka') }}</h2>
            <ul class="ml-4 list-disc">
              <li>
                {{
                  ls.t(
                    'Selecting an answer or writing down a short answer',
                    'Výber odpovede, alebo zapísanie krátkého odpovede'
                  )
                }}
              </li>
              <li>
                {{
                  ls.t(
                    'After responding, the user sees the results of the poll',
                    'Po odpovedaní používateľ vidí výsledky hlasovania'
                  )
                }}
              </li>
              <li>
                <h3 class="text-xl font-medium">
                  {{ ls.t('Voting results', 'Výsledky hlasovania') }}
                </h3>
                <ul class="ml-4 list-disc">
                  <li>{{ ls.t('Open-ended question', 'Otázka s otvorenou odpoveďou') }}</li>
                  <li>
                    {{
                      ls.t(
                        'WordCloud button - turn off/on word cloud for voting results',
                        'Tlačidlo WordCloud - vypnutie/zapnutie word cloud-u pre výsledky hlasovania'
                      )
                    }}
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('Questions', 'Otázky') }}</h2>
            <ul class="ml-4 list-disc">
              <li>
                <h3 class="text-xl font-medium">
                  {{ ls.t('Creating a question', 'Vytvorenie otázky') }}
                </h3>
                <ul class="ml-4 list-disc">
                  <li>
                    {{
                      ls.t(
                        'By clicking on the Create New Question button, a small panel will appear where the user can write a question',
                        'Kliknutím na tlačidlo Vytvoriť novú otázku sa objaví malý panel, kde používateľ si môže napísať otázku'
                      )
                    }}
                  </li>
                  <li>
                    {{
                      ls.t(
                        'For each question, choose the subject for which the question belongs',
                        'Pre každú otázku si treba vybrať predmet, pre ktorý patrí otázka'
                      )
                    }}
                  </li>
                  <li>
                    {{
                      ls.t(
                        'By clicking on the + and - button predefined questions can be added, for open questions the number of answers must be 0',
                        'Kliknutím na tlačidlo + a - sa môžu pridať dopredu definované otázky, pre otvorené otázky počet odpovedí musí byť 0'
                      )
                    }}
                  </li>
                  <li>
                    {{
                      ls.t(
                        'Click the Create button to create a new question',
                        'Kliknutím na tlačidlo Vytvoriť sa vytvorí nová otázka'
                      )
                    }}
                  </li>
                </ul>
              </li>
              <li>
                <h3 class="text-xl font-medium">
                  {{ ls.t('Filtering questions', 'Filtrovanie otázok') }}
                </h3>
                <ul class="ml-4 list-disc">
                  <li>
                    {{
                      ls.t(
                        'Selecting a subject from Subject will filter the questions by that subject',
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
                        'Click on the question to see the question with the current and archived answers, a 5 digit code and a QR code',
                        'Kliknutím na otázku sa zobrazí otázka s aktuálnymi a archivovanými odpoveďmi, 5 ciferný kód a QR kód'
                      )
                    }}
                  </li>
                  <li>
                    {{
                      ls.t(
                        'Clicking the Archive button closes the question and archives it with the note entered by the user',
                        'Kliknutím na tlačidlo Archivovať otázka sa uzavrie a archivuje sa s poznámkou, ktorý zadá používateľ'
                      )
                    }}
                  </li>
                  <li>
                    {{
                      ls.t(
                        'Clicking the Duplicate button duplicates the question with the new codes',
                        'Kliknutím na tlačidlo Duplikovať otázka sa duplikuje s novými kódmi'
                      )
                    }}
                  </li>
                  <li>
                    {{
                      ls.t(
                        'Clicking the Export button will export the question as a .json file',
                        'Kliknutím na tlačidlo Exportovať otázka sa exportuje ako .json súbor'
                      )
                    }}
                  </li>
                  <li>
                    {{
                      ls.t(
                        'Click the Edit button to edit the question and the subject of the question',
                        'Kliknutím na tlačidlo Upraviť sa dá upraviť otázku a predmet otázky'
                      )
                    }}
                  </li>
                  <li>
                    {{
                      ls.t(
                        'Clicking the Delete button will delete the question',
                        'Kliknutím na tlačidlo Vymazať otázka sa vymaže'
                      )
                    }}
                  </li>
                  <li>
                    {{
                      ls.t(
                        'Turning the WordCloud button on/off turns the word cloud on/off for the question',
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
                        'Filtered questions can be exported by clicking the Export button below the subject selection',
                        'Vyfiltrované otázky sa dajú exportovať kliknutím na tlačidlo Exportovať pod výberom predmetu'
                      )
                    }}
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('User name', 'Meno používateľa') }}</h2>
            <ul class="ml-4 list-disc">
              <li>
                <h3 class="text-xl font-medium">{{ ls.t('My profile', 'Môj profil') }}</h3>
                <ul class="ml-4 list-disc">
                  <li>{{ ls.t('Display of personal data', 'Zobrazenie osobných údajov') }}</li>
                </ul>
              </li>
              <li>
                <h3 class="text-xl font-medium">{{ ls.t('Change password', 'Zmeniť heslo') }}</h3>
                <ul class="ml-4 list-disc">
                  <li>
                    {{
                      ls.t(
                        'By entering the old password and the new password twice, the user can change the password',
                        'Zadaním starého hesla a dvakrát nového hesla používateľ si môže zmeniť heslo'
                      )
                    }}
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('Logout', 'Odhlásenie') }}</h2>
            <ul class="ml-4 list-disc">
              <li>
                {{
                  ls.t(
                    'Clicking the Logout button logs the user out',
                    'Kliknutím na tlačidlo Odhlásenie používateľ sa odhlási'
                  )
                }}
              </li>
            </ul>
          </li>
        </ul>

        <h1 class="text-3xl font-bold mt-8 mb-6 text-[var(--color-heading)]">
          {{ ls.t('Administrator', 'Administrátor') }}
        </h1>
        <ul class="text-[var(--color-text)] space-y-4">
          <li>
            {{
              ls.t(
                'All functionalities of the logged-in user plus (therefore only new functionalities will be written)',
                'Všetky funkcionality prihláseného používateľa plus (preto budú napísané iba nové funkcionality)'
              )
            }}
          </li>
          <li>{{ ls.t('Access to all questions', 'Prístup všetkým otázkám') }}</li>
          <li>
            {{
              ls.t(
                'Creating questions on behalf of another user',
                'Vytvorenie otázok v mene iného používateľa'
              )
            }}
          </li>
          <li>{{ ls.t('User management', 'Správa používateľov') }}</li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('Menu', 'Menu') }}</h2>
            <ul class="ml-4 list-disc">
              <li>{{ ls.t('Users - Manage users', 'Používateľia - Správa používateľov') }}</li>
            </ul>
          </li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('Questions', 'Otázky') }}</h2>
            <ul class="ml-4 list-disc">
              <li>
                <h3 class="text-xl font-medium">
                  {{ ls.t('Creating a question', 'Vytvorenie otázky') }}
                </h3>
                <ul class="ml-4 list-disc">
                  <li>
                    {{
                      ls.t(
                        'As well as the logged in plus user must select the user for whom they are creating the question',
                        'Tak isto ako prihlásený používateľ plus si musí vybrať používateľa, pre ktorého vytvára otázku'
                      )
                    }}
                  </li>
                </ul>
              </li>
              <li>
                <h3 class="text-xl font-medium">
                  {{ ls.t('Filtering questions', 'Filtrovanie otázok') }}
                </h3>
                <ul class="ml-4 list-disc">
                  <li>
                    {{
                      ls.t(
                        'Selecting a subject from Subject and a user from User will filter the queries by that subject and user',
                        'Vybraním predmetu z Predmet a používateľa z Používateľ sa vyfiltrujú otázky podľa daného predmetu a používateľa'
                      )
                    }}
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li>
            <h2 class="text-2xl font-semibold">{{ ls.t('Users of', 'Používateľia') }}</h2>
            <ul class="ml-4 list-disc">
              <li>
                {{
                  ls.t(
                    'Users table, where you can see the First Name, Last Name, Email and Role of the user',
                    'Tabuľka používateľov, kde je vidno Meno, Priezvisko, E-mail a Rola používateľa'
                  )
                }}
              </li>
              <li>{{ ls.t('Deleting a user', 'Odstránenie používateľa') }}</li>
              <li>
                {{
                  ls.t(
                    'Clicking on the button with the garbage can symbol deletes the user',
                    'Kliknutím na tlačidlo so symbolom smetiaka sa vymaže používateľ'
                  )
                }}
              </li>
              <li>{{ ls.t('Edit user', 'Úprava používateľa') }}</li>
              <li>
                {{
                  ls.t(
                    'Click on the button with the pencil symbol to open the user edit page',
                    'Kliknutím na tlačidlo so symbolom ceruzky sa otvorí stránka úpravy používateľa'
                  )
                }}
              </li>
              <li>
                {{
                  ls.t(
                    'Administrator can edit email, first name, last name, user role',
                    'Administrátor môže upraviť email, meno, priezvisko, rolu používateľa'
                  )
                }}
              </li>
              <li>
                {{
                  ls.t(
                    'Pre uloženie zmien treba stlačiť tlačidlo Uložiť',
                    'Pre uloženie zmien treba stlačiť tlačidlo Uložiť'
                  )
                }}
              </li>
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
