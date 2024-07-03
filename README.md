# Ledenadministratie Systeem

## A. Beschrijving Ontwikkelomgeving

Voor de ontwikkeling van dit ledenadministratiesysteem is gebruik gemaakt van de volgende technologieën:

- **PHP**: Server-side scripting taal om de logica van de applicatie te verwerken.
- **MySQL**: Relationele database voor het opslaan van de gegevens.
- **AMPPS**: Een lokaal ontwikkelplatform dat Apache, MySQL, PHP omvat.
- **HTML/CSS**: Voor de opmaak en structuur van de webpagina's.
- **JavaScript**: Voor client-side validatie en dynamische functionaliteiten.
- **MVC-architectuur**: Om de logica, presentatie en data gescheiden te houden.

## B. Beschrijving Database

De database bestaat uit meerdere tabellen die de relaties tussen families, familieleden, soorten leden, contributie en boekjaren beheren. Hieronder een overzicht van de belangrijkste tabellen en hun velden:

### Tabellen en Velden

1. **familie**
   - id (INT, primary key)
   - naam (VARCHAR)
   - adres (VARCHAR)

2. **familielid**
   - id (INT, primary key)
   - naam (VARCHAR)
   - geboortedatum (DATE)
   - soort_lid_id (INT, foreign key naar soortlid)
   - familie_id (INT, foreign key naar familie)

3. **soortlid**
   - id (INT, primary key)
   - omschrijving (VARCHAR)

4. **contributie**
   - id (INT, primary key)
   - leeftijd (INT)
   - soort_lid_id (INT, foreign key naar soortlid)
   - bedrag (DECIMAL)

5. **boekjaar**
   - id (INT, primary key)
   - jaar (YEAR)

## C. Beschrijving Werking Applicatie

De applicatie biedt een interface voor het beheren van families en familieleden, en het berekenen van contributies. De belangrijkste functies zijn:

1. **Dashboard**: Welkomstpagina met navigatie naar verschillende secties.
2. **Familieleden beheren**: Mogelijkheid om familieleden toe te voegen, te bewerken, te bekijken en te verwijderen.
3. **Families beheren**: Mogelijkheid om families toe te voegen, te bewerken, te bekijken en te verwijderen.
4. **Contributie berekenen**: Op basis van leeftijd en soort lid wordt de contributie automatisch berekend.
5. **Boekjaren beheren**: Mogelijkheid om boekjaren toe te voegen, te bewerken, te bekijken en te verwijderen.
6. **Authenticatie**: Gebruikers kunnen zich registreren en inloggen om toegang te krijgen tot de applicatie.

### Gebruikte Patronen

- **MVC (Model-View-Controller)**: Om de logica, presentatie en data gescheiden te houden.
- **CRUD (Create, Read, Update, Delete)**: Voor het beheren van gegevens in de database.

## D. Testverslag van de Applicatie

De applicatie is getest op de volgende functionaliteiten:

1. **Registratie en Inloggen**:
   - Gebruikers kunnen zich registreren met een gebruikersnaam, e-mailadres en wachtwoord.
   - Inloggen werkt correct en geeft toegang tot het dashboard.

2. **Familieleden Beheren**:
   - Familieleden kunnen worden toegevoegd met naam, geboortedatum en bijbehorende familie.
   - Bewerken en verwijderen van familieleden werkt correct.
   - De lijst met familieleden wordt correct weergegeven.

3. **Families Beheren**:
   - Families kunnen worden toegevoegd met naam en adres.
   - Bewerken en verwijderen van families werkt correct.
   - De lijst met families wordt correct weergegeven.

4. **Contributie Berekenen**:
   - Contributie wordt automatisch berekend op basis van de leeftijd en het soort lid.
   - Correcte weergave en berekening van contributiebedragen.

5. **Boekjaren Beheren**:
   - Boekjaren kunnen worden toegevoegd, bewerkt en verwijderd.
   - De lijst met boekjaren wordt correct weergegeven.

### Gebruikte Testmethoden

- **Unit Tests**: Voor het testen van individuele functies in de controllers en modellen.
- **Integratietests**: Voor het testen van de volledige CRUD-functionaliteit en de interactie tussen verschillende onderdelen van de applicatie.
- **User Acceptance Testing (UAT)**: Voor het verifiëren dat de applicatie voldoet aan de gestelde eisen en goed functioneert vanuit het perspectief van de eindgebruiker.

### Testresultaten

Alle tests zijn succesvol uitgevoerd en de applicatie functioneert zoals verwacht zonder kritieke fouten. Eventuele kleine bugs en verbeterpunten zijn gedocumenteerd en opgelost.