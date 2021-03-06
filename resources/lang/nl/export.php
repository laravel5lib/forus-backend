<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Export Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default headers for exporting the list of 
    |   - Providers used by the sponsor class.
    |   - Transactions used by the sponsor and provider class
    | Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    
    'providers'              => [
		'provider' => 'Aanbieder',
		'email' => 'e-mail',
		'phone' => 'telefoonnummer',
        'categories' => 'categoriën',
        'kvk' => 'kvk',
        'state' => 'status',
	'allow_budget' => 'Geaccepteerd: budget',
	'allow_products' => 'Geaccepteerd: aanbiedingen',
	'allow_some_products' => 'Geaccepteerd: specifieke aanbiedingen',
    ],

    'voucher_transactions'    => [
		'amount' => 'bedrag',
		'date' => 'datum',
		'fund' => 'fonds',
        'provider' => 'aanbieder',
        'state' => 'status',
        'state-values' => [
            'success' => 'voltooid', 
            'pending' => 'in afwachting',
        ]
    ]
];
