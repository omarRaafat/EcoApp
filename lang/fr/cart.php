<?php

return [
    "api" => [
        "product_deleted" => "produit supprimé",
        "products_retrived" => "Les produits ont été récupérés avec succès",
        'cart_not_found' => 'Panier introuvable',
        'cart_is_empty' => 'Le panier est vide',
        'cart_updated' => 'Panier mis à jour',
        'cart_wrong' => 'Une erreur est survenue',
        'checkout_succesfully' => 'La requête a réussi',
        'cannot_checkout_product_missing' => "La commande n'a pas pu être complétée, le produit n'est pas disponible actuellement",
        'payment_order_generated' => 'Ordre de paiement généré',
        'reorder_successfully'=>'réorganiser avec succès',
        'cannot_reorder'=>'cannot reorder',
        'reorder_with_missings'=>'la commande a été réorganisée mais certains articles ne sont pas disponibles',
        'cart_updated_with_missings' => 'Le panier a été mis à jour mais il manque des articles',
        'not_enough_amount_wallet' => 'Désolé, pas assez de portefeuille',
        'gateway-error' => 'Il y a un problème avec la passerelle de paiement, réessayez',
        'address-out-of-coverage' => 'Adresse hors couverture',
        'coupon-not-started' => 'coupon non commencé, date de début du coupon (:date)',
        'coupon-expired' => 'coupon expiré',
        'coupon-not-active' => 'non disponible actuellement',
        'coupon-not-exists' => 'Le coupon saisi n\'est pas valide',
        'coupon-exceed-usage' => "le coupon a dépassé l'utilisation",
        'coupon-missed-order-minimum' => "Le coupon de réduction ne s\'applique pas à votre panier",
        'coupon-missed-delivery-minimum' => "Le bon de réduction ne s\'applique pas à votre panier",
        'address-not-exists' => "Nous n'avons pas l'adresse",
        'coupon-applied' => "coupon appliqué avec succès",
        'address-selected' => "L'adresse a été sélectionnée avec succès",
        'checkout' => [
            'address_id' => 'Adresse',
            'use_wallet' => 'Utiliser le portefeuille',
            'shipping_id' => 'Mode de livraison',
            'payment_id' => 'Mode de paiement',
        ],
        'product-missed-country' => "Veuillez supprimer ces produits (:products), car ils ne sont pas disponibles pour la livraison dans le pays sélectionné",
        'product-missed-country-deleted' => 'Ces produits (:products) ont été supprimés, car ils ne sont pas disponibles pour la livraison dans le pays sélectionné',
        'cannot_reorder-some-product-missed' => 'Certains produits ne sont pas disponibles pour l`heure actuelle',
        'address-is-international' => "Vous ne pouvez pas payer en espèces pour les commandes internationales",
        'delivery-date' => 'Date de livraison estimée de: :dateFrom à :dateTo',
        'internationl-order' => [
            'out-of-weight-range' => "Poids autorisé pour les commandes internationales De :weightFrom kg à :weightTo kg",
            'maximum-amount' => "Le montant maximum pour une commande internationale :amount",
        ],
    ]
];
