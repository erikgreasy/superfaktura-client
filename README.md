# SuperFaktúra PHP api client
PHP api klient pre komunikáciu s REST api systémom SuperFaktúra.

## Všebecné / Motivácia
Motiváciou k vytvoreniu tohto balíčku bolo časté využívanie (výborného) fakturačného softvéru SuperFaktúra. Existujúci first party [PHP api klient](https://github.com/superfaktura/apiclient) je bohužiaľ už nekompatibilný s novými PHP verziami a jeho používanie na projektoch bolo čím ďalej náročnejšie. Preto som sa rozhodol vytvoriť vlastný api klient, ktorý by bol použiteľný v novších projektoch, do budúcna zjednodušenie práce s api, strongly typed parametre... Oficiálnu REST api dokumentáciu je možné nájsť na [tejto adrese](https://github.com/superfaktura/docs).

**Projekt je vyvíjaný ako víkendový projekt, nápady na zlepšenia a PR sú vítané.**

## Požiadavky
PHP >= 8.1

## Inštalácia
Inštalácia je možná cez nástroj Composer:
```
composer require erikgreasy/superfaktura-client
```

## Použitie

### Vytvorenie klienta
Pre komunikáciu s api, je v prvom kroku potrebné vytvoriť inštanciu triedy Superfaktura, pomocou ktorej prebiehajú všetky volania.

Vytvorenie klienta (údaje email a apiKey je možné nájsť vo vašej administrácii SuperFaktúry v časti Nástroje - API)
```PHP
use Erikgreasy\Superfaktura\Superfaktura;

$sf = new Superfaktura(
    email: 'email@example.com',
    apiKey: 'vygenerovany_api_kluc',
    isSandbox: true // pouzitie sandbox modu - optional parameter
);
```

### Vytvorenie faktúry
Pre vytváranie faktúr v systéme je možné využiť nasledujúcu ukážku kódu. Štruktúra parametrov metód vychádza zo [štruktúry REST api pre vyváranie faktúry](https://github.com/superfaktura/docs/blob/master/invoice.md#add-invoice). 
```PHP
$response = $sf
    ->newInvoice()
    ->setClient([
        'name' => 'Klient s.r.o.'
    ])
    ->addItem([
        'name' => 'Položka 1',
        'unit_price' => 20,
    ])
    ->addItem([
        'name' => 'Položka 2',
        'unit_price' => 20,
        'quantity' => 2,
    ])
    ->save();
```
