insert into Vraag values (1, 'Hoe heet Omaaa')

insert into Gebruiker values ('piet', 'piet', 'hein', 'edeseweg 19', 'A', '6543VC', 'ede', 'Nederland', '01-01-1997', 'test@hotmail.com', '1234', 1, 'Heinse', 1)

insert into Verkoper values ('piet', 'Rabobank', 3433432, 'Post', '???')

insert into Voorwerp (
    Titel, Beschrijving, Startprijs, Betalingswijze,
    Betalingsinstructie, Plaatsnaam, Land, Looptijd,
    LooptijdbeginDag, LooptijdbeginTijdstip, Verzendkosten, Verzendinstructies,
    Verkoper, Koper, LooptijdeindeDag, LooptijdEindeTijdstip,
    VeilingGesloten, Verkoopprijs) VALUES (
    'Leren Bank', 'Mooie leren bank.',
    10.00, 'paypal',
    '???', 'Ede',
    'Nederland', '3',
    '04/04/2021', '10:10',
    8.50, 'via vrachtwagen!',
    'piet', null,
    '10/10/2021', '10:40',
    1, 25.00
    )

insert VoorwerpInRubriek values (1, 18)