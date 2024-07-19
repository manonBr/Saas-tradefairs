@php 
$optionsFamille = [
    'GROSSISTES' => 'WHOLESALER',
    'DETAILLANT' => 'SHOP'
    ];
    
    $optionsCountry = [
        'AF' => 'Afghanistan',
        'SA' => 'Arabia',
        'AM' => 'Armenia',
        'AU' => 'Australia',
        'AZ' => 'Azerbaijan',
        'BH' => 'Bahrain',
        'BR' => 'Brasil',
        'CA' => 'Canada',
        'DJ' => 'Djibouti',
        'EC' => 'Ecuador',
        'EG' => 'Egypt',
        'ER' => 'Eritrea',
        'ET' => 'Ethiopia',
        'FR' => 'France',
        'GE' => 'Georgia',
        'GS' => 'Georgia (South) and South sandwich islands',
        'DE' => 'Germany',
        'IN' => 'India',
        'IR' => 'Iran',
        'IQ' => 'Iraq',
        'IL' => 'Israel',
        'KW' => 'Kuwait',
        'JO' => 'Jordan',
        'LB' => 'Lebanon',
        'LY' => 'Libya',
        'MA' => 'Morocco',
        'MX' => 'Mexico',
        'OM' => 'Oman',
        'PK' => 'Pakistan',
        'QA' => 'Qatar',
        'SO' => 'Somalia',
        'ES' => 'Spain',
        'SD' => 'Sudan',
        'SS' => 'Sudan (South)',
        'SY' => 'Syria',
        'TR' => 'Türkiye',
        'TM' => 'Turkmenistan',
        'AE' => 'United Arab Emirates (UAE)',
        'US' => 'United States of Amercia (USA)',
        'UZ' => 'Uzbekistan',
        'YE' => 'Yemen',
        'divide' => '_______',
        'ZA' => 'Afrique',
        'AX' => 'Åland, îles',
        'AL' => 'Albanie',
        'DZ' => 'Algérie',
        'AD' => 'Andorre',
        'AO' => 'Angola',
        'AI' => 'Anguilla',
        'AQ' => 'Antarctique',
        'AG' => 'Antigua',
        'AR' => 'Argentine',
        'AW' => 'Aruba',
        'AT' => 'Autriche',
        'BS' => 'Bahamas',
        'BD' => 'Bangladesh',
        'BB' => 'Barbade',
        'BY' => 'Bélarus',
        'BE' => 'Belgique',
        'BZ' => 'Belize',
        'BJ' => 'Bénin',
        'BM' => 'Bermudes',
        'BT' => 'Bhoutan',
        'BO' => 'Bolivie, l\'état plurinational de',
        'BQ' => 'Bonaire, saint eustache et saba',
        'BA' => 'Bosnie herzégovine',
        'BW' => 'Botswana',
        'BV' => 'Bouvet, île',
        'BN' => 'Brunei darussalam',
        'BG' => 'Bulgarie',
        'BF' => 'Burkina faso',
        'BI' => 'Burundi',
        'KY' => 'Caïmans',
        'KH' => 'Cambodge',
        'CM' => 'Cameroun',
        'CV' => 'Cap vert',
        'CF' => 'Centrafricaine, république',
        'CL' => 'Chili',
        'CN' => 'Chine',
        'CX' => 'Christmas, île',
        'CY' => 'Chypre',
        'CC' => 'Cocos (keeling), îles',
        'CO' => 'Colombie',
        'KM' => 'Comores',
        'CG' => 'Congo',
        'CD' => 'Congo, la république démocratique du',
        'CK' => 'Cook, îles',
        'KR' => 'Corée, république de',
        'KP' => 'Corée, république populaire démocratique de',
        'CR' => 'Costa rica',
        'CI' => 'Côte d\'ivoire',
        'HR' => 'Croatie',
        'CU' => 'Cuba',
        'CW' => 'Curaçao',
        'DK' => 'Danemark',
        'DO' => 'Dominicaine, république',
        'DM' => 'Dominique',
        'SV' => 'El salvador',
        'EE' => 'Estonie',
        'FK' => 'Falkland, îles (malvinas)',
        'FO' => 'Féroé, îles',
        'FJ' => 'Fidji',
        'FI' => 'Finlande',
        'GA' => 'Gabon',
        'GM' => 'Gambie',
        'GH' => 'Ghana',
        'GI' => 'Gibraltar',
        'GR' => 'Grèce',
        'GD' => 'Grenade',
        'GL' => 'Groenland',
        'GP' => 'Guadeloupe',
        'GU' => 'Guam',
        'GT' => 'Guatemala',
        'GG' => 'Guernesey',
        'GN' => 'Guinée',
        'GW' => 'Guinée bissau',
        'GQ' => 'Guinée équatoriale',
        'GY' => 'Guyana',
        'GF' => 'Guyane française',
        'HT' => 'Haïti',
        'HM' => 'Heard et îles macdonald, île',
        'HN' => 'Honduras',
        'HK' => 'Hong kong',
        'HU' => 'Hongrie',
        'IM' => 'Île de man',
        'UM' => 'Îles mineures éloignées des états unis',
        'VG' => 'Îles vierges britanniques',
        'VI' => 'Îles vierges des états unis',
        'ID' => 'Indonésie',
        'IE' => 'Irlande',
        'IS' => 'Islande',
        'IT' => 'Italie',
        'JM' => 'Jamaïque',
        'JP' => 'Japon',
        'JE' => 'Jersey',
        'KZ' => 'Kazakhstan',
        'KE' => 'Kenya',
        'KG' => 'Kirghizistan',
        'KI' => 'Kiribati',
        'LA' => 'Lao, république démocratique populaire',
        'LS' => 'Lesotho',
        'LV' => 'Lettonie',
        'LR' => 'Libéria',
        'LI' => 'Liechtenstein',
        'LT' => 'Lituanie',
        'LU' => 'Luxembourg',
        'MO' => 'Macao',
        'MK' => 'Macédoine, l\'ex république yougoslave de',
        'MG' => 'Madagascar',
        'MY' => 'Malaisie',
        'MW' => 'Malawi',
        'MV' => 'Maldives',
        'ML' => 'Mali',
        'MT' => 'Malte',
        'MP' => 'Mariannes du nord, îles',
        'MH' => 'Marshall, îles',
        'MQ' => 'Martinique',
        'MU' => 'Maurice',
        'MR' => 'Mauritanie',
        'YT' => 'Mayotte',
        'FM' => 'Micronésie, états fédérés de',
        'MD' => 'Moldova, république de',
        'MC' => 'Monaco',
        'MN' => 'Mongolie',
        'ME' => 'Monténégro',
        'MS' => 'Montserrat',
        'MZ' => 'Mozambique',
        'MM' => 'Myanmar',
        'NA' => 'Namibie',
        'NR' => 'Nauru',
        'NP' => 'Népal',
        'NI' => 'Nicaragua',
        'NE' => 'Niger',
        'NG' => 'Nigéria',
        'NU' => 'Niué',
        'NF' => 'Norfolk, île',
        'NO' => 'Norvège',
        'NC' => 'Nouvelle calédonie',
        'NZ' => 'Nouvelle zélande',
        'IO' => 'Océan indien, territoire britannique de l\'',
        'UG' => 'Ouganda',
        'PW' => 'Palaos',
        'PS' => 'Palestinien occupé, territoire',
        'PA' => 'Panama',
        'PG' => 'Papouasie nouvelle guinée',
        'PY' => 'Paraguay',
        'NL' => 'Pays bas',
        'PE' => 'Pérou',
        'PH' => 'Philippines',
        'PN' => 'Pitcairn',
        'PL' => 'Pologne',
        'PF' => 'Polynésie française',
        'PR' => 'Porto rico',
        'PT' => 'Portugal',
        'RE' => 'Réunion',
        'RO' => 'Roumanie',
        'GB' => 'Royaume uni',
        'RU' => 'Russie, fédération de',
        'RW' => 'Rwanda',
        'EH' => 'Sahara occidental',
        'BL' => 'Saint barthélemy',
        'SH' => 'Sainte hélène, ascension et tristan da cunha',
        'LC' => 'Sainte lucie',
        'KN' => 'Saint kitts et nevis',
        'SM' => 'Saint marin',
        'MF' => 'Saint martin(partie française)',
        'SX' => 'Saint martin (partie néerlandaise)',
        'PM' => 'Saint pierre et miquelon',
        'VA' => 'Saint siège (état de la cité du )',
        'VC' => 'Saint vincent et les grenadines',
        'SB' => 'Salomon, îles',
        'WS' => 'Samoa',
        'AS' => 'Samoa américaines',
        'ST' => 'Sao tomé et principe',
        'SN' => 'Sénégal',
        'RS' => 'Serbie',
        'SC' => 'Seychelles',
        'SL' => 'Sierra leone',
        'SG' => 'Singapour',
        'SK' => 'Slovaquie',
        'SI' => 'Slovénie',
        'LK' => 'Sri lanka',
        'SE' => 'Suède',
        'CH' => 'Suisse',
        'SR' => 'Suriname',
        'SJ' => 'Svalbard et île jan mayen',
        'SZ' => 'Swaziland',
        'TJ' => 'Tadjikistan',
        'TW' => 'Taïwan, province de chine',
        'TZ' => 'Tanzanie, république unie de',
        'TD' => 'Tchad',
        'CZ' => 'Tchèque, république',
        'TF' => 'Terres australes françaises',
        'TH' => 'Thaïlande',
        'TL' => 'Timor leste',
        'TG' => 'Togo',
        'TK' => 'Tokelau',
        'TO' => 'Tonga',
        'TT' => 'Trinité et tobago',
        'TN' => 'Tunisie',
        'TC' => 'Turks et caïcos, îles',
        'TV' => 'Tuvalu',
        'UA' => 'Ukraine',
        'UY' => 'Uruguay',
        'VU' => 'Vanuatu',
        'VE' => 'Venezuela, république bolivarienne du',
        'VN' => 'Vietnam',
        'WF' => 'Wallis et futuna',
        'ZM' => 'Zambie',
        'ZW' => 'Zimbabwe' 
    ]
@endphp

<x-layout>
    <x-slot:title>
        Eliquid France | Pris de contact
    </x-slot>
   <div class="container">
        <h1>Fiche contact</h1>
        @empty ($errors)
            @include('shared.error', ['content' => 'Une erreur est survenue !'])
        @endempty

        
        <form action="{{ route('contact-add') }}" method="post" id='form'>
        @csrf
        <fieldset class="fieldset--discreet">
            <legend>Informations commercial</legend>
            <div class="flex">
                <div class="flex__item">
                        @include('components.form.input', ['type' => 'text', 'name' => 'collaborator', 'label' => 'Code collaborateur', 'required' => true, 'readonly' => true, 'defaultValue' => 'CR00006'])
                    </div>
                    <div class="flex__item">
                        @include('components.form.select', ['name' => 'famille', 'label' => 'Category', 'required' => true, 'caption' => 'Please select a category', 'options' => $optionsFamille])
                    </div>
                </div>
            </fieldset>
            <div class="flex">
                <div class="flex__item">
                    @include('components.form.input', ['type' => 'radio', 'name' => 'gender', 'value' => 'monsieur', 'label' => 'Mr.', 'required' => true, 'checked' => true])
                </div>
                <div class="flex__item">
                    @include('components.form.input', ['type' => 'radio', 'name' => 'gender', 'value' => 'madame', 'label' => 'Mrs.', 'required' => true])
                </div>
            </div>
            @error('gender')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="column column--four">
                <div class="column__item">
                    <div>
                        @include('components.form.input', ['type' => 'text', 'name' => 'lastname', 'label' => 'Lastname', 'required' => true])
                    </div>
                    <div>
                        @include('components.form.input', ['type' => 'text', 'name' => 'firstname', 'label' => 'Firstname'])
                    </div>
                </div>
                <div class="column__item">
                    <div>
                        @include('components.form.input', ['type' => 'text', 'name' => 'company', 'label' => 'Company', 'required' => true])
                    </div>
                    <div>
                        @include('components.form.input', ['type' => 'text', 'name' => 'function', 'label' => 'Function'])
                    </div>
                </div>
                <div class="column__item"></div>
                <div class="column__item column__item--spotlight">
                    <div>
                        @include('components.form.input', ['type' => 'text', 'name' => 'siret', 'label' => 'SIRET'])
                    </div>
                    <div>
                        @include('components.form.input', ['type' => 'text', 'name' => 'tva', 'label' => 'VAT'])
                    </div>
                </div>
            </div>
            <div class="column column--two">
                <div class="column__item">
                    <fieldset>
                        <legend>Coordonnées</legend>
                        <div class="column column--two">
                            <div class="column__item">
                                <div>
                                    @include('components.form.input', ['type' => 'tel', 'name' => 'mobile', 'label' => 'Mobile'])
                                </div>
                                <div>
                                    @include('components.form.input', ['type' => 'email', 'name' => 'email', 'label' => 'Email', 'required' => true])
                                </div>
                            </div>
                            <div class="column__item">
                                <div>
                                    @include('components.form.input', ['type' => 'tel', 'name' => 'phone', 'label' => 'Phone'])
                                </div>
                            </div>
                        </div>
                        
                    </fieldset>
                </div>
                <div class="column__item">
                    <fieldset>
                        <legend>Adresse</legend>
                        <div class="column column--two">
                            <div class="column__item">
                                <div>
                                    @include('components.form.input', ['type' => 'text', 'name' => 'adress', 'label' => 'Adress 1'])
                                </div>
                                <div>
                                    @include('components.form.input', ['type' => 'text', 'name' => 'adressBis', 'label' => 'Adress 2'])
                                </div>
                            </div>
                            <div class="column__item">
                                <div>
                                    @include('components.form.input', ['type' => 'text', 'name' => 'zipcode', 'label' => 'Zip Code'])
                                </div>
                                <div>
                                    @include('components.form.input', ['type' => 'text', 'name' => 'city', 'label' => 'City'])
                                </div>
                            </div>
                        </div>
                        <div>
                            @include('components.form.select', ['name' => 'country', 'label' => 'Country', 'caption' => 'Please select a country', 'options' => $optionsCountry])
                        </div>
                    </fieldset>
                </div>
            </div>
            
            <div>
                @include('components.form.textarea', ['name' => 'notes', 'label' => 'Notes', 'rows' => 7])
            </div>
            
            <div>
                @include('components.form.input', ['type' => 'checkbox', 'name' => 'newContact', 'value' => 'new', 'label' => 'New Eliquid France customer?'])
            </div>

            <div>
                <button class="btn btn--primary btn--form">Save</button>
            </div>
            <p><span class="required">*</span> Required fields</p>
        </form>
    </div>
</x-layout>