<?php

use App\Enums\CustomerWithdrawRequestEnum;
use App\Enums\OrderStatus;
use App\Enums\ShippingMethodType;

return [
    "dashboard" => "tableau de contrôle",
    "menu" => "liste de contrôle",
    "name" => "le nom",
    "name_ar" => "Le nom est en arabe",
    "name_en" => "Le nom est en anglais",
    "image" => "Image",
    "phone" => "téléphone portable",
    "email" => "e-mail",
    "email_placeholder" => "Entrez l'e-mail",
    "password_placeholder" => "Entrer le mot de passe",
    "forgot_password" => "Mot de passe oublié ?",
    "forgot_password_email" => "Récupération de mot de passe",
    "forgot_password_email_notes" =>
        "Vous pouvez réinitialiser votre mot de passe à partir du lien ci-dessous :",
    "forgot_password_notes" =>
        "Entrez votre e-mail et les instructions de réinitialisation du mot de passe seront envoyées à cet e-mail",
    "password" => "mot de passe",
    "new_password" => "mot de passe",
    "confirm_new_password" => "Confirmation mot de passe",
    "password_reset" => "Réinitialiser le mot de passe",
    "confirm_new_password_placeholder" =>
        "Entrez le mot de passe de confirmation",
    "remember_me" => "Souviens-toi de moi",
    "sign_in" => "s'identifier",
    "sign" => "entrée",
    "close" => "Fermer",
    "add" => "Ajouter",
    "save" => "sauvegarder",
    "reset" => "Réinitialiser",
    "back" => "Retour",
    "create" => "construction",
    "edit" => "amendement",
    "send" => "envoyer",
    "desc_order" => "descendant",
    "asc_order" => "Progressive",
    "not_found" => "indisponible",
    "order_placed" => "Heure d'envoi de la demande",
    "an_order_has_been_placed" => "La demande a été envoyée par le client",
    "admin" => "administrateur",
    "price" => "le prix",
    "errors" => "données incorrectes",
    "remember_login" => "Vous êtes-vous souvenu de vos données ?",
    "actions" => "procédures",
    "yes" => "Oui",
    "no" => "Non",
    "quantity" => "Quantité",
    "last_update" => "Dernière mise à jour",
    "payment_data" => "données de paiement",
    "address_data" => "Données de localisation et d'adresse",
    "created_at" => "Date créée",
    "Showing" => "examen",
    "to" => "pour",
    "of" => "depuis",
    "from" => "depuis",
    "results" => "Résultats",
    "select" => "Choisir",
    "welcome" => "Bonjour",
    "notifications" => [
        "unread" => "Notifications non lues",
        "notifications" => "Avis",
        "vendor" => [
            "modify" => [
                "title" => "Stocker les données",
                "message" =>
                    "Les données du magasin ont été modifiées par la direction",
            ],
            "warning" => [
                "title" => "Avertissement de la direction",
            ],
            "product" => [
                "approve" => [
                    "title" => "Produit approuvé :",
                    "message" =>
                        "Les modifications du produit sont approuvées par la direction",
                ],
                "reject" => [
                    "title" => "Produit refusé :",
                    "message" =>
                        "Les modifications apportées au produit ont été rejetées par la direction",
                ],
                "modify" => [
                    "title" => "Modifier un produit :",
                    "message" => "Le produit a été modifié par la direction",
                ],
            ],
            "order" => [
                "created" => [
                    "title" => "nouvelle requête",
                    "message" =>
                        "Une nouvelle requête a été créée avec le code : #",
                ],
            ],
        ],
        "admin" => [
            "transaction" => [
                "created" => [
                    "title" => "nouvelle requête",
                    "message" =>
                        "Une nouvelle requête a été créée avec le code : #",
                ],
            ],
        ],
    ],
    "vendor_website" => "site Internet",
    "vendors" => "Magasins",
    "vendors_list" => "Tous les magasins",
    "vendors_show" => "vue du magasin",
    "vendors_edit" => "Modification du magasin",
    "vendor_logo" => "Logo du magasin",
    "vendor_owner_name" => "Nom du propriétaire du magasin",
    "vendor_name" => "Nom du magasin",
    "vendor_phone" => "téléphone portable",
    "vendor_second_phone" => "mobile supplémentaire",
    "vendor_tax_number" => "Numéro d'identification fiscale",
    "vendor_tax_certificate" => "Attestation de taxe sur la valeur ajoutée",
    "vendor_iban_certificate" => "Certificat IBAN",
    "vendor_commercial_register" => "registre du commerce",
    "vendor_commercial_register_date" =>
        "La date d'expiration de l'enregistrement commercial",
    "vendor_bank" => "Nom de banque",
    "vendor_bank_number" => "numéro de compte bancaire",
    "vendor_broc" => "Certificat de propriété de la marque",
    "vendor_iban" => "Numéro IBAN",
    "vendor_email" => "E-mail du magasin",
    "vendor_password" => "mot de passe",
    "vendor_password_confirm" => "Confirmation mot de passe",
    "vendor_address" => "l'adresse",
    "vendor_admin_percentage" => "pourcentage de gestion",
    "vendor_admin_percentage_order" => "Classement par pourcentage de gestion",
    "vendor_admin_percentage_hint" =>
        "Mettre le pourcentage de gestion des ventes du vendeur",
    "vendor_wallet" => "Portefeuille",
    "vendor_products" => "produits clients",
    "vendor_rate" => "Évaluation",
    "vendor_sales" => "les ventes",
    "vendor_description" => "Description du magasin",
    "vendor_external_warehouse" => "entrepôts externes",
    "vendor_status" => "Statut du magasin",
    "vendor_registration_date" => "date d'enregistrement",
    "vendor_active" => "Activé",
    "vendor_inactive" => "Pas activé",
    "vendor_pending" => "L'approbation du magasin est en attente",
    "vendor_approved" => "Le magasin a été approuvé",
    "vendor_not_approved" => "Magasin refusé",
    "vendor_warnings" => "Avertissements de magasin",
    "vendor_warning" => "L'avertissement",
    "vendor_warning_new" => "Nouvel avertissement",
    "vendor_warning_new_add" => "Ajouter un nouvel avertissement",
    "vendor_warning_date" => "Date d'avertissement",
    "vendor_warning_send" =>
        "Un avertissement a été envoyé au magasin avec succès",
    "vendor_active_on" => "La boutique est activée",
    "vendor_active_off" => "La boutique est désactivée",
    "vendor_commission" =>
        "Pourcentage de gestion du prix de vente (%) (achat depuis la plateforme)",
    "vendor_is_international" =>
        "Permettre au magasin de traiter à l'international",
    "transactions" => "Demandes",
    "transaction_edit" => "amendement",
    "transactions_list" => "Toutes les demandes",
    "delivery_fees" => "Frais de livraison",
    "city" => "Ville",
    "payment_method" => "mode de paiement",
    "total" => "Le montant total",
    "total_sub" => "Le montant payé",
    "paid_amount" => "Le montant payé",
    "coupon-discount" => "montant de la remise",
    "vendors_count" => "Nombre de vendeurs",
    "shipping" => "Expédition",
    "all" => "tout le monde",
    "registered" => "inscrit",
    "shipping_done" => "c'est chargé",
    "in_delivery" => "Il est connecté",
    "completed" => "complété",
    "canceled" => "Annulé",
    "refund" => "retour",
    "transaction_show" => "Regarder la demande",
    "transaction_main_details" => "Données de commande principales",
    "transaction_id" => "code requis",
    "transaction_date" => "La date de candidature",
    "transaction_status" => "Statut de la commande",
    "transaction_note" => "Remarques sur la commande",
    "transaction_customer_filter_placeholder" =>
        "Recherche par numéro ou nom de client",
    "transaction_id_filter_placeholder" => "Rechercher par code de requête",
    "transaction_not_has_ship" =>
        "La commande n'a pas de numéro de suivi pour l'expédition, ce qui signifie qu'elle n'a pas été envoyée à la compagnie maritime",
    "transaction_status_not_high" =>
        "Le statut de la demande ne peut pas être converti en un précédent",
    "transaction_vendor_product" => "produits de la boutique (:vendeur)",
    "transaction_invoice" => [
        "app_name" => "Le Centre National des Palmiers et des Dattes",
        "title" => "la demande",
        "header_title" => "demande de commande",
        "invoice_brif" => "Récapitulatif de la commande",
        "address" => "l'adresse",
        "zip_code" => "Numéro de poste",
        "legal_registration_no" => "Numéro d'enregistrement légal",
        "client_name" => "Le destinataire",
        "client_sale" => "l'acheteur",
        "email" => "E-mail",
        "bill_info" => "Données de l'acheteur",
        "ship_info" => "Données du destinataire",
        "website" => "le site",
        "contact_no" => "numéro de contact",
        "invoice_no" => "numéro de commande",
        "date" => "La date de candidature",
        "payment_status" => "statut de remboursement",
        "total_amount" => "commande totale",
        "shipping_address" => "adresse de livraison",
        "phone" => "téléphone portable",
        "sub_total" => "Sous-prix",
        "estimated_tax" => "Impôt",
        "tax_no" => "Numéro d'identification fiscale",
        "discount" => "Rabais",
        "shipping_charge" => "frais d'expédition",
        "download" => "demande de téléchargement",
        "print" => "Imprimer la demande",
        "not_found" => "Il n'y a pas de produits pour cette commande",
        "shipment_no" => "numéro de livraison",
        "payment_type" => "mode de paiement",
        "sub_from_wallet" => "déduit du portefeuille",
        "sub_total_without_vat" => "Le total n'inclut pas les taxes",
        "vat_percentage" => "taux d'imposition",
        "vat_rate" => "valeur fiscale",
        "products_table_header" => [
            "product_details" => "le produit",
            "rate" => "prix unitaire",
            "quantity" => "Quantité",
            "amount" => "Le total n'inclut pas les taxes",
            "tax_ratio" => "taux d'imposition",
            "tax_value" => "valeur fiscale",
            "barcode" => "code à barre",
            "total_with_tax" => "Le total est TTC",
        ],
    ],
    "customers_list" => "clients",
    "customer_details" => "Données client",
    "customer_name" => "nom du client",
    "customer_phone" => "Numéro de portable du client",
    "customer_email" => "E-mail du client",
    "customer_avatar" => "photo client",
    "customer_addresses_count" => "nombre d'adresses",
    "customer_transactions_count" => "Le nombre de commandes",
    "customer_warnings_count" => "Le nombre de signalements",
    "customer_priority" => "Importance du client",
    "customer_banned" => "Interdiction de client",
    "customer_last_login" => "dernière entrée",
    "customer_last_activity" => "Dernière Activité",
    "customer_change_priority_message" =>
        "L'importance du client a été modifiée avec succès",
    "customer_perfect" => "idéal",
    "customer_important" => "Important",
    "customer_show" => "Données client",
    "customer_edit" => "Modifier les données client",
    "customer_regular" => "normal",
    "customer_parasite" => "Parasitaire",
    "customer_caution" => "Prends en soin",
    "customer_noDeal" => "Ne pas s'en occuper",
    "customer_unblocked" => "L'interdiction a été levée du client",
    "customer_blocked" => "Le client a été bloqué",
    "customer_new_password" =>
        "(laissez-le vide si vous ne l'avez pas modifié) Mot de passe",
    "customer_confirm_new_password" => "Confirmation mot de passe",
    "customer_registration_date" => "date d'enregistrement",
    "customer_addresses" => "adresses clients",
    "price_before_offer" => "Prix avant enchère",
    "address_description" => "Description du titre",
    "edits_history" => "Journal des modifications",
    "address_type" => "Type d'adresse",
    "address_id" => "Numéro d'identification de l'adresse",
    "desc_en" => "Descriptif en anglais",
    "desc_ar" => "Descriptif en arabe",
    "category_id" => "section principale",
    "sub_category_id" => "Première sous-section",
    "final_category_id" => "dernière sous-section",
    "type_id" => "classe",
    "order" => "arrangement",
    "width" => "l'offre",
    "height" => "hauteur",
    "length" => "hauteur",
    "total_weight" => "le poids total",
    "net_weight" => "poids net",
    "quantity_bill_count" => "Le numéro de la quantité",
    "bill_weight" => "Le numéro de la quantité",
    "customer_finances" => [
        "title" => "finances des clients",
        "payment_methods" => [
            "cash" => "espèces",
            "visa" => "Visa",
            "wallet" => "Portefeuille",
        ],
        "wallets" => [
            "all_wallets" => "Tout conservateur",
            "id" => "ID de portefeuille",
            "create" => "Créer un nouveau portefeuille",
            "edit" => "Modifier le portefeuille du client",
            "manage" => "Gestion portefeuille clients",
            "delete" => "Supprimer le portefeuille",
            "import" => "importer des portefeuilles",
            "search" => "Rechercher dans les portefeuilles",
            "title" => "Portefeuilles de satisfaction client",
            "single_title" => "portefeuille client",
            "customer_name" => "nom du client",
            "attachments" => "pièces jointes",
            "no_attachments" => "Il n'y a pas de pièces jointes",
            "by_admin" => "par",
            "is_active" => "statut d'activation",
            "last_update" => "Dernière mise à jour",
            "active" => "actif",
            "inactive" => "pas actif",
            "choose_state" => "Sélectionnez le statut du portefeuille",
            "choose_customer" => "Choisissez un client",
            "amount" => "équilibre",
            "reason" => "la raison",
            "created_at" => "La date de création du portefeuille",
            "created_at_select" => "Choisissez une date",
            "all" => "tout le monde",
            "filter" => "filtration",
            "no_result_found" => "Aucun résultat trouvé",
            "attachment" => "pièces jointes",
            "has_attachment" => "Aperçu de la pièce jointe",
            "has_no_attachment" => "Il n'y a pas de pièces jointes",
            "change_status" => "Changer le statut du portefeuille",
            "manage_wallet_balance" => "Gestion du solde du portefeuille",
            "current_wallet_balance" => "solde actuel du portefeuille",
            "wallet_balance" => "solde du portefeuille",
            "wallets_transactions" => [
                "title" => "opérations de portefeuille",
                "single_title" => "transaction de portefeuille",
                "customer_name" => "nom du client",
                "wallet_id" => "ID de portefeuille",
                "type" => "Type d'opération",
                "amount" => "Le montant de la transaction",
                "transaction_date" => "Date de la transaction",
            ],
            "validations" => [
                "customer_id_required" => "Le champ client est obligatoire",
                "customer_id_unique" =>
                    "Il n'est pas possible de créer plus d'un portefeuille pour un client",
            ],
            "messages" => [
                "created_successfully_title" => "Nouveau portefeuille clients",
                "created_successfully_body" =>
                    "Un nouveau portefeuille de clients a été créé avec succès",
                "created_error_title" =>
                    "La création du portefeuille client a échoué",
                "created_error_body" =>
                    "La création d'un nouveau portefeuille client a échoué",
                "updated_successfully_title" =>
                    "Modifier le statut du portefeuille d'un client",
                "updated_successfully_body" =>
                    "Le statut du portefeuille d'un client a été modifié avec succès",
                "updated_error_title" =>
                    "Impossible de modifier l'état du portefeuille d'un client",
                "updated_error_body" =>
                    "L'opération de modification de l'état du portefeuille d'un client a échoué",
                "customer_has_wallet_title" =>
                    "Impossible de créer un portefeuille pour ce client",
                "customer_has_wallet_message" =>
                    "Il n'est pas possible de créer un wallet pour ce client car il en possède déjà un",
            ],
            "customer_info" => [
                "email" => "Poster",
                "phone" => "téléphone portable",
            ],
            "transaction" => [
                "title" => "Gestion du solde du portefeuille",
                "wallet_transactions_log" =>
                    "Historique des transactions du portefeuille",
                "id" => "identifiant de transaction",
                "type" => "Type d'opération",
                "choose_type" => "Choisissez le type d'opération",
                "amount" => "Valeur transactionnelle",
                "date" => "Date de la transaction",
                "add" => "Ajouter +",
                "sub" => "rival -",
                "success_add_title" => "Processus d'ajout de crédit réussi",
                "success_add_message" =>
                    "La carte du client a été créditée avec succès",
                "success_sub_title" => "Déduction de crédit réussie",
                "success_sub_message" =>
                    "Le solde de la carte du client a été débité avec succès",
                "fail_add_title" => "Échec de l'ajout de crédit",
                "fail_add_message" =>
                    "Échec de l'opération de crédit de la carte de crédit",
                "fail_sub_title" => "Échec de la déduction du solde",
                "fail_sub_message" => "Le débit de la carte du client a échoué",
                "cannot_subtract_message" =>
                    "Le solde de la carte est inférieur aux valeurs de remise",
                "user_id" => "Le processus a été fait par",
                "transaction_type" => [
                    "title" => "Type d'opération",
                    "choose_transaction_type" =>
                        "Choisissez le type d'opération",
                    "purchase" => "acheter des produits",
                    "gift" => "cadeau",
                    "bank_transfer" => "virement",
                    "compensation" => "compensation",
                    "sales_balance" => "Solde des ventes",
                ],
                "opening_balance" => "Solde d'ouverture",
                "validations" => [
                    "amount_required" =>
                        "Le champ de la valeur de la transaction est obligatoire",
                    "amount_numeric" =>
                        "La valeur de la transaction doit être une valeur numérique",
                    "type_required" =>
                        "Le champ Type de transaction est obligatoire",
                    "type_numeric" =>
                        "Vous devez sélectionner le type de transaction",
                    "transaction_type_required" =>
                        "Le champ Type d'opération est obligatoire",
                    "transaction_type_numeric" =>
                        "Le type d'opération doit être sélectionné",
                ],
                "save" => "Enregistrez le processus",
            ],
        ],
        "customer-cash-withdraw" => [
            "page-title" => "Demandes de retrait de solde client",
            "show-page-title" => "Demande de retrait du solde du client",
            "status" => "Statut de la commande",
            "approved" => "acceptable",
            "not-approved" => "inacceptable",
            "customer-name-search" =>
                "Recherche par nom de client ou numéro de mobile",
            "customer-name" => "nom du client",
            "customer-phone" => "Mobile du client",
            "customer-balance" => "Solde du portefeuille client",
            "request-id" => "numéro de commande",
            "request-amount" => "montant de la commande",
            "request-bank-name" =>
                "Le nom de la banque à laquelle il est transféré",
            "admin-approved" => "A été approuvé",
            "admin-not-approved" => "accès refusé",
            "all-status" => "tous les cas",
            "statuses" => [
                CustomerWithdrawRequestEnum::PENDING =>
                    "La réception de la demande",
                CustomerWithdrawRequestEnum::APPROVED =>
                    "La demande a été exécutée",
                CustomerWithdrawRequestEnum::NOT_APPROVED =>
                    "la demande a été rejetée",
            ],
            "request-bank-account-name" => "Nom du titulaire du compte",
            "request-bank-account-iban" =>
                "Le numéro IBAN vers lequel il est transféré",
            "reject-reason" => "la raison du refus",
            "rejected-by" => "Rejeté par",
            "save-status" => "Modifier le statut de la demande",
            "bank-receipt" => "Reçu de virement ci-joint",
            "validations" => [
                "status-required" =>
                    "L'état de la demande de transfert est requis",
                "status-in" =>
                    "Le statut de la demande de transfert doit être (Exécuté, Rejeté ou Reçu)",
                "reject_reason-required_if" => "Le motif du refus est requis",
                "bank_receipt-required_if" =>
                    "La pièce jointe du reçu de transfert est requise",
                "bank_receipt-image" =>
                    "La pièce jointe du récépissé de virement doit être une copie",
                "bank_receipt-max" =>
                    "La taille maximale de la pièce jointe du reçu de transfert est de 2 Mo",
                "transaction_type-required_if" =>
                    "Le type d'opération demandée",
                "transaction_type-in" =>
                    "Le type d'opération doit être l'un des types disponibles",
            ],
            "messages" => [
                "status-not-pending" =>
                    "Cette demande ne peut pas changer de statut car elle a déjà été modifiée",
                "status-set-to-not-approved" =>
                    "Le statut de la demande rejetée a été modifié avec succès",
                "status-set-to-approved" =>
                    "Le statut de la demande a été modifié avec succès",
            ],
        ],
        "manage_wallet_balance" => "Gestion portefeuille clients",
    ],
    "categories" => [
        "title_main" => "Catégories et rubriques",
        "title" => "sections",
        "single_title" => "Section",
        "all_categories" => "Toutes les rubriques",
        "choose_search_lang" => "Choisissez la langue du nom",
        "manage_categories" => "Gestion de département",
        "id" => "ID de service",
        "name_ar" => "nom arabe",
        "name_en" => "Le nom est en anglais",
        "slug_ar" => "Lien de la section en arabe",
        "slug_en" => "Lien vers la rubrique en anglais",
        "level" => "le niveau",
        "parent_id" => "Suivez la rubrique",
        "child_id" => "appartenir à une sous-section",
        "is_active" => "la condition",
        "active" => "actif",
        "inactive" => "Inactif",
        "edit_child" => "Modifier la sous-section",
        "edit_sub_child" => "Modifier la dernière sous-section",
        "order" => "classement",
        "yes" => "Oui",
        "no" => "Non",
        "create" => "Créer une nouvelle rubrique",
        "update" => "Modifier une rubrique",
        "search" => "recherche",
        "all" => "tout le monde",
        "filter" => "filtration",
        "created_at_select" => "Choisissez une date",
        "parent_name_ar" => "Le nom du département principal en arabe",
        "parent_name_en" => "Le nom du département principal en anglais",
        "not_found" => "rien",
        "parent" => "le principal",
        "child" => "sous",
        "subchild" => "Final",
        "child_count" => "Le nombre de sous-sections",
        "show" => "Afficher les données de section",
        "delete" => "supprimer",
        "arabic_date" => "Données arabes",
        "english_date" => "Données en anglais",
        "choose_category" => "Choisissez un département",
        "choose_sub_category" => "Sélectionnez une sous-section",
        "choose_level" => "Sélectionnez le niveau du département",
        "image_for_show" => "image de la section",
        "image" => "Sélectionnez l'image de la section",
        "image_title" => "Faites glisser l'image de la section ici",
        "delete_modal" => [
            "title" => "Vous êtes sur le point de supprimer une section ?",
            "description" =>
                "La suppression de votre candidature supprimera toutes vos informations de notre base de données.",
        ],
        "messages" => [
            "created_successfully_title" =>
                "La section a été créée avec succès",
            "created_successfully_body" => "La section a été créée avec succès",
            "created_error_title" =>
                "Erreur lors de la création de la partition",
            "created_error_body" =>
                "Une erreur s'est produite lors de la création de la partition",
            "updated_successfully_title" =>
                "La section a été modifiée avec succès",
            "updated_successfully_body" =>
                "La section a été modifiée avec succès",
            "updated_error_title" =>
                "Erreur lors de la modification de la partition",
            "updated_error_body" =>
                "Une erreur s'est produite lors de la modification de la partition",
            "deleted_successfully_title" =>
                "La section a été supprimée avec succès",
            "deleted_successfully_message" =>
                "La section a été supprimée avec succès",
            "deleted_error_title" =>
                "Erreur lors de la suppression de la partition",
            "deleted_error_message" =>
                "Une erreur s'est produite lors de la suppression de la partition",
        ],
        "validations" => [
            "name_ar_required" => "Le nom du département en arabe est requis",
            "name_ar_string" =>
                "Le nom de la section arabe doit être une chaîne",
            "name_ar_min" =>
                "Le nombre minimum de lettres pour le nom du département arabe est d'au moins 3 lettres",
            "name_en_required" => "Le nom du département en anglais est requis",
            "name_en_string" =>
                "Le nom de la section anglaise doit être une chaîne",
            "name_en_min" =>
                "Le plus petit nombre de lettres dans le nom du département d'anglais est d'au moins 3 lettres",
            "slug_ar_required" => "Le lien de la section en arabe est requis",
            "slug_ar_string" =>
                "Le lien pour la section arabe doit être une chaîne",
            "slug_ar_min" =>
                "Le nombre minimum de caractères pour le lien de la section arabe est d'au moins 3 lettres",
            "slug_en_required" => "Le lien de la section en anglais est requis",
            "slug_en_string" =>
                "L'URL de la section doit être sous la forme d'une chaîne de texte",
            "slug_en_min" =>
                "Le nombre minimum de caractères pour le lien de section en anglais est d'au moins 3 caractères",
            "level_numeric" =>
                "Le niveau de partition doit être de type numérique",
            "level_between" =>
                "Le niveau de la section doit être (Main - Sub - Sub - Final)",
            "parent_id_numeric" =>
                "L'identifiant de partition avec la valeur numérique la plus élevée",
            "parent_id_exists" => "Rubrique introuvable",
            "is_featured_boolean" =>
                "La valeur de ce champ doit être numérique",
            "is_active_boolean" => "La valeur de ce champ doit être numérique",
            "order_unique" => "L'ordre des sections ne peut pas être répété",
            "image_required" => "Le champ Image de la section est obligatoire",
            "image_image" => "Le fichier doit être de type image",
            "image_mimes" => "Extensions acceptées : jpeg, png, jpg, gif, svg",
            "image_max" => "La taille maximale de l'image est de 2048 Ko",
        ],
    ],
    "productClasses" => [
        "name"=>"le nom",
        "title" => "catégories",
        "single_title" => "classe",
        "all_productClasses" => "Toutes catégories",
        "manage_productClasses" => "Gestion des catégories",
        "id" => "ID de catégorie",
        "name_ar" => "nom arabe",
        "name_en" => "Le nom est en anglais",
        "yes" => "Oui",
        "no" => "Non",
        "create" => "Créer une nouvelle catégorie",
        "update" => "Modification de classe",
        "search" => "recherche",
        "all" => "tout le monde",
        "filter" => "filtration",
        "created_at_select" => "Choisissez une date",
        "not_found" => "rien",
        "show" => "Afficher les données de catégorie",
        "delete" => "supprimer",
        "delete_modal" => [
            "title" => "Êtes-vous sur le point de supprimer une catégorie ?",
            "description" =>
                "La suppression de votre candidature supprimera toutes vos informations de notre base de données.",
        ],
        "messages" => [
            "created_successfully_title" => "Catégorie créée avec succès",
            "created_successfully_body" => "Catégorie créée avec succès",
            "created_error_title" => "Erreur lors de la création de la classe",
            "created_error_body" =>
                "Une erreur s'est produite lors de la création de la catégorie",
            "updated_successfully_title" =>
                "La catégorie a été modifiée avec succès",
            "updated_successfully_body" =>
                "La catégorie a été modifiée avec succès",
            "updated_error_title" =>
                "Erreur lors de la modification de la classe",
            "updated_error_body" =>
                "Une erreur s'est produite lors de la modification de la catégorie",
            "deleted_successfully_title" =>
                "La catégorie a été supprimée avec succès",
            "deleted_successfully_message" =>
                "La catégorie a été supprimée avec succès",
            "deleted_error_title" =>
                "Erreur lors de la suppression de la catégorie",
            "deleted_error_message" =>
                "Une erreur s'est produite lors de la suppression de la catégorie",
        ],
        "validations" => [
            "name_ar_required" => "Le nom de la catégorie en arabe est requis",
            "name_ar_string" =>
                "Le nom de la classe arabe doit être de type String",
            "name_ar_min" =>
                "Le nombre minimum de lettres pour le nom de la catégorie arabe est d'au moins 3 lettres",
            "name_en_required" =>
                "Le nom de la catégorie en anglais est requis",
            "name_en_string" =>
                "Le nom de la classe en anglais doit être de type String",
            "name_en_min" =>
                "Le nombre minimum de lettres dans le nom de la catégorie en anglais est d'au moins 3 lettres",
        ],
    ],
    "products" => [
        "title" => "des produits",
        "single_title" => "le produit",
        "all_products" => "Tous les produits",
        "manage_products" => "Gestion des produits",
        "in_review_products" => "Produits en cours d'examen",
        "id" => "Identifiant du produit",
        "name_ar" => "nom arabe",
        "name_en" => "Le nom est en anglais",
        "follow_edits" => "Suivi des modifications",
        "desc_ar" => "Description du produit en arabe",
        "desc_en" => "Description du produit en anglais",
        "is_featured" => "Produit en vedette",
        "is_active" => "la condition",
        "active" => "actif",
        "inactive" => "Inactif",
        "price" => "le prix",
        "unitPrice" => "prix unitaire",
        "total" => "Le prix total du produit",
        "order" => "classement",
        "category" => "Section",
        "vendor" => "la boutique",
        "pending" => "mon voisin",
        "in_review" => "en cours d'évaluation",
        "holded" => "suspendu",
        "yes" => "Oui",
        "no" => "Non",
        "create" => "Créer un nouveau produit",
        "update" => "Modifier un produit",
        "search" => "recherche",
        "all" => "tout le monde",
        "filter" => "filtration",
        "created_at_select" => "Choisissez une date",
        "not_found" => "rien",
        "show" => "une offre",
        "delete" => "supprimer",
        "edit" => "amendement",
        "vendor_id" => "la boutique",
        "arabic_date" => "Données arabes",
        "english_date" => "Données en anglais",
        "choose_category" => "Choisissez un département",
        "image" => "Choisissez l'image du produit",
        "image_title" => "Faites glisser l'image du produit ici",
        "accepting" => "Acceptation du produit",
        "re-pending" =>
            "Sélectionnez le produit comme produit en cours d'exécution",
        "field_changed" => "Changements effectués",
        "images" => "Photos du produit",
        "reject" => "Refuser les modifications",
        "write_your_reject_reason" => "Écrivez le motif du refus",
        "reject_reason" => "Refuser les modifications",
        "reject_confirm" => "Confirmer le rejet",
        "accept_update" => "Accepter les modifications",
        "updated_products" => "Produits mis à jour",
        "pending_products" => "Produits en attente",
        "delete_modal" => [
            "title" => "Vous êtes sur le point de supprimer un produit ?",
            "description" =>
                "La suppression de votre commande supprimera toutes les informations relatives à ce produit.",
        ],
        "messages" => [
            "created_successfully_title" => "Produit créé avec succès",
            "created_successfully_body" => "Produit créé avec succès",
            "created_error_title" => "Erreur lors de la création du produit",
            "created_error_body" =>
                "Une erreur s'est produite lors de la création du produit",
            "updated_successfully_title" =>
                "Le produit a été modifié avec succès",
            "updated_successfully_body" =>
                "Le produit a été modifié avec succès",
            "updated_error_title" =>
                "Erreur lors de la modification du produit",
            "updated_error_body" =>
                "Une erreur s'est produite lors de la modification du produit",
            "deleted_successfully_title" =>
                "Le produit a été supprimé avec succès",
            "deleted_successfully_message" =>
                "Le produit a été supprimé avec succès",
            "deleted_error_title" => "Erreur lors de la suppression du produit",
            "deleted_error_message" =>
                "Une erreur s'est produite lors de la suppression du produit",
            "status_changed_successfully_title" =>
                "Le statut du produit a été modifié avec succès",
            "status_approved_successfully_title" =>
                "Le produit a été accepté avec succès",
        ],
        "print-barcode" => "Impression de codes-barres",
        "barcode" => "code à barre",
        "image-validation" =>
            "La largeur minimale de l'image doit être de 800 pixels et la hauteur minimale de l'image doit être de 800 pixels",
        "image-validation-width" =>
            "La largeur minimale de l'image doit être de 800 pixels",
        "image-validation-height" =>
            "La longueur minimale de l'image doit être de 800 pixels",
        "image-validation-max" =>
            "Les images doivent être inférieures à 1 500 Ko",
        "product_details" => "Détails du produit",
        "product_price" => "Prix du produit",
        "product_quantity" => "Quantité",
        "product_reviews" => "Notes",
        "product_price_final" => "Le prix final comprend les taxes",
        "prices" => [
            "countries" => "Prix du produit selon chaque pays",
        ],
    ],
    "countries_and_cities_title" => "États et villes",
    "coupons_title" => "coupons",
    "countries" => [
        "name"=>"le nom",
        "title" => "Des pays",
        "single_title" => "Pays",
        "all_countries" => "Tous les pays",
        "manage_countries" => "Gestion des états",
        "id" => "Identifiant du pays",
        "name_ar" => "nom arabe",
        "name_en" => "Le nom est en anglais",
        "is_active" => "la condition",
        "yes" => "Oui",
        "no" => "Non",
        "create" => "Créer un nouvel état",
        "update" => "Modification de l'état",
        "search" => "recherche",
        "all" => "tout le monde",
        "filter" => "filtration",
        "not_found" => "rien",
        "show" => "Afficher les données du pays",
        "delete" => "supprimer",
        "active" => "actif",
        "inactive" => "pas actif",
        "filter_is_active" => "Filtrer par statut",
        "code" => "code",
        "choose_state" => "Sélectionnez l'état du pays",
        "country_areas" => "régions de l'état",
        "area_id" => "ID de région",
        "area_name" => "Nom de la zone",
        "national" => "local",
        "not_national" => "non local",
        "is_national" => "Le pays est-il local ?",
        "delete_modal" => [
            "title" => "Êtes-vous sur le point de supprimer un pays ?",
            "description" =>
                "La suppression de votre candidature supprimera toutes vos informations de notre base de données.",
        ],
        "messages" => [
            "created_successfully_title" => "L'état a été créé avec succès",
            "created_successfully_body" => "L'état a été créé avec succès",
            "created_error_title" => "Erreur lors de la création de l'état",
            "created_error_body" =>
                "Une erreur s'est produite lors de la création de l'état",
            "updated_successfully_title" => "L'état a été modifié avec succès",
            "updated_successfully_body" => "L'état a été modifié avec succès",
            "updated_error_title" => "Erreur lors de la modification de l'état",
            "updated_error_body" =>
                "Une erreur s'est produite lors de la modification du pays",
            "deleted_successfully_title" =>
                "Le pays a été supprimé avec succès",
            "deleted_successfully_message" =>
                "Le pays a été supprimé avec succès",
            "deleted_error_title" => "Erreur lors de la suppression du pays",
            "deleted_error_message" =>
                "Une erreur s'est produite lors de la suppression du pays",
        ],
        "validations" => [
            "name_ar_required" => "Le nom du pays en arabe est obligatoire",
            "name_ar_string" => "Le nom du pays arabe doit être une chaîne",
            "name_ar_min" =>
                "Le nombre minimum de lettres dans le nom du pays arabe est d'au moins 3 lettres",
            "name_en_required" => "Le nom du pays en anglais est requis",
            "name_en_string" =>
                "Le nom du pays en anglais doit être une chaîne",
            "name_en_min" =>
                "Le plus petit nombre de lettres dans le nom du pays anglais est d'au moins 3 lettres",
            "code_required" => "Le code pays est requis",
            "code_string" => "Le code pays doit être de type String",
            "code_min" =>
                "Le nombre minimum de caractères pour le code pays est d'au moins 2 caractères",
        ],
        "vat_percentage" => "TVA (%)",
    ],
    "cities" => [
        "name"=>"le nom",
        "title" => "les villes",
        "single_title" => "Ville",
        "all_cities" => "Toutes les villes",
        "manage_cities" => "Gestion des villes",
        "id" => "Identifiant de la ville",
        "name_ar" => "nom arabe",
        "name_en" => "Le nom est en anglais",
        "is_active" => "la condition",
        "yes" => "Oui",
        "no" => "Non",
        "create" => "Créer une nouvelle ville",
        "update" => "Modifier une ville",
        "search" => "recherche",
        "all" => "tout le monde",
        "filter" => "filtration",
        "not_found" => "rien",
        "show" => "Afficher les données de la ville",
        "delete" => "supprimer",
        "active" => "actif",
        "inactive" => "pas actif",
        "filter_is_active" => "Filtrer par statut",
        "choose_state" => "Sélectionnez l'état de la ville",
        "choose_area" => "Sélectionnez la région",
        "area_id" => "Région",
        "torod_city_id" => "L'identifiant de la ville de la société de colis",
        "areas_cities" => "Les quartiers de la ville",
        "delete_modal" => [
            "title" => "Vous êtes sur le point de supprimer une ville ?",
            "description" =>
                "La suppression de votre candidature supprimera toutes vos informations de notre base de données.",
        ],
        "messages" => [
            "created_successfully_title" =>
                "La ville a été établie avec succès",
            "created_successfully_body" => "La ville a été établie avec succès",
            "created_error_title" => "Erreur lors de la création de la ville",
            "created_error_body" =>
                "Quelque chose s'est mal passé lors de la création de la ville",
            "updated_successfully_title" =>
                "La ville a été modifiée avec succès",
            "updated_successfully_body" =>
                "La ville a été modifiée avec succès",
            "updated_error_title" =>
                "Erreur lors de la modification de la ville",
            "updated_error_body" =>
                "Une erreur s'est produite lors de la modification de la ville",
            "deleted_successfully_title" =>
                "La ville a été supprimée avec succès",
            "deleted_successfully_message" =>
                "La ville a été supprimée avec succès",
            "deleted_error_title" =>
                "Erreur lors de la suppression de la ville",
            "deleted_error_message" =>
                "Une erreur s'est produite lors de la suppression de la ville",
            "cannot_delete_city_title" =>
                "Vous ne pouvez pas supprimer la ville",
            "cannot_delete_city_body" =>
                "Vous ne pouvez pas supprimer une ville associée à une zone de livraison",
        ],
        "validations" => [
            "name_ar_required" => "Le nom de la ville en arabe est requis",
            "name_ar_string" => "Le nom de la ville arabe doit être une chaîne",
            "name_ar_min" =>
                "Le nombre minimum de lettres dans le nom de la ville arabe est d'au moins 3 lettres",
            "name_en_required" => "Le nom de la ville en anglais est requis",
            "name_en_string" =>
                "Le nom de la ville en anglais doit être une chaîne",
            "name_en_min" =>
                "Le plus petit nombre de lettres dans le nom de la ville en anglais est d'au moins 3 lettres",
            "country_id_required" => "L'état est obligatoire",
            "torod_city_id_string" =>
                "L'identifiant de la ville de la société de colis doit être une valeur textuelle",
        ],
    ],
    "areas" => [
        "name"=>"le nom",
        "title" => "Régions",
        "single_title" => "Région",
        "all_areas" => "Tous parlant",
        "manage_areas" => "Gestion des enceintes",
        "id" => "ID de région",
        "name_ar" => "nom arabe",
        "name_en" => "Le nom est en anglais",
        "yes" => "Oui",
        "no" => "Non",
        "create" => "Créer une nouvelle région",
        "update" => "zone d'édition",
        "search" => "recherche",
        "all" => "tout le monde",
        "filter" => "filtration",
        "not_found" => "rien",
        "show" => "Afficher les données de la zone",
        "delete" => "supprimer",
        "choose_state" => "Sélectionnez l'état de la région",
        "choose_country" => "Choisissez le pays",
        "country_id" => "Pays",
        "is_active" => "la condition",
        "active" => "actif",
        "inactive" => "pas actif",
        "delete_modal" => [
            "title" => "Vous êtes sur le point de supprimer pixelisé",
            "description" =>
                "La suppression de votre candidature supprimera toutes vos informations de notre base de données.",
        ],
        "messages" => [
            "created_successfully_title" => "La zone a été créée avec succès",
            "created_successfully_body" => "La zone a été créée avec succès",
            "created_error_title" => "Erreur lors de la création de la région",
            "created_error_body" =>
                "Une erreur s'est produite lors de la création de la région",
            "updated_successfully_title" =>
                "La région a été modifiée avec succès",
            "updated_successfully_body" =>
                "La région a été modifiée avec succès",
            "updated_error_title" =>
                "Erreur lors de la modification de la région",
            "updated_error_body" =>
                "Une erreur s'est produite lors de la modification de la région",
            "deleted_successfully_title" =>
                "La région a été supprimée avec succès",
            "deleted_successfully_message" =>
                "La région a été supprimée avec succès",
            "deleted_error_title" =>
                "Erreur lors de la suppression de la région",
            "deleted_error_message" =>
                "Une erreur s'est produite lors de la suppression de la région",
        ],
        "validations" => [
            "name_ar_required" =>
                "Le nom de la région en arabe est obligatoire",
            "name_ar_string" =>
                "Le nom de la région arabe doit être une chaîne",
            "name_ar_min" =>
                "Le nombre minimum de lettres dans le nom de la région arabe est d'au moins 3 lettres",
            "name_en_required" => "Le nom de la région en anglais est requis",
            "name_en_string" =>
                "Le nom de la région anglaise doit être une chaîne",
            "name_en_min" =>
                "Le plus petit nombre de lettres dans le nom anglais de la région est d'au moins 3 lettres",
            "country_id_required" => "L'état est obligatoire",
        ],
    ],
    "static-content" => [
        "title" => "Contenu du site Web",
        "about-us" => [
            'title' => 'Titre de la section',
            'paragraphe' => 'Description de la partie',
            "page-title" => "Gérer une page sur la plateforme",
            "create" => "Ajouter une section sur la plateforme",
            "search" => "recherche",
            "title_ar" => "Le titre de la section est en arabe",
            "title_en" => "Le titre de la section est en anglais",
            "show" => "Voir une section sur la plateforme",
            "edit" => "Modifier une section sur la plateforme",
            "delete_modal" => [
                "title" => "Supprimer une section sur la plateforme",
                "description" =>
                    "Vous souhaitez supprimer une rubrique sur la plateforme ?",
            ],
            "delete" => "Supprimer une section sur la plateforme",
            "paragraph_ar" => "Section Description Arabe",
            "paragraph_en" => "Description de la section Français",
        ],
        "validations" => [
            "title_ar_required" => "Titre de la section L'arabe est requis",
            "title_ar_string" =>
                "Le titre de la section doit être une chaîne de type arabe",
            "title_ar_min" =>
                "Le nombre minimum de caractères pour le titre de la section arabe est d'au moins 3 caractères",
            "title_ar_max" =>
                "Le plus grand nombre de lettres dans le titre de la section arabe est de 600 caractères au maximum",
            "title_en_required" => "Titre de la section L'anglais est requis",
            "title_en_string" =>
                "Le titre de la section doit être une chaîne en anglais",
            "title_en_min" =>
                "Le nombre minimum de caractères pour le titre de la section en anglais est d'au moins 3 caractères",
            "title_en_max" =>
                "Le plus grand nombre de lettres dans le titre de la section est l'anglais, 600 caractères au maximum",
            "paragraph_en_required" =>
                "Description de la section L'anglais est requis",
            "paragraph_en_string" =>
                "La description de la section doit être dans le type anglais d'une chaîne",
            "paragraph_en_min" =>
                "Le nombre minimum de caractères pour la description de la section en anglais est d'au moins 50 caractères",
            "paragraph_en_max" =>
                "Le nombre maximum de caractères pour la description de la section en anglais est de 1000 caractères ou plus",
            "paragraph_ar_required" => "Section Description L'arabe est requis",
            "paragraph_ar_string" =>
                "La description de la section doit être en arabe de type String",
            "paragraph_ar_min" =>
                "Le nombre minimum de caractères pour la description de la section arabe est d'au moins 50 caractères",
            "paragraph_ar_max" =>
                "Le nombre maximum de caractères pour la description de la section arabe est de 1000 caractères ou plus",
        ],
        "messages" => [
            "success" => "opération réussie",
            "warning" => "avertissement",
            "error" => "erreur",
            "section-created" => "La section a été créée avec succès",
            "section-updated" => "La section a été modifiée avec succès",
            "section-deleted" => "La section a été supprimée avec succès",
            "section-not-deleted" =>
                "La section ne peut pas être supprimée pour le moment",
        ],
        "privacy-policy" => [
            'title' => 'Titre de la section',
            'paragraphe' => 'Description de la partie',
            "page-title" => "Gérer la page de politique de confidentialité",
            "create" => "Ajouter une section de politique de confidentialité",
            "search" => "recherche",
            "title_ar" => "Le titre de la section est en arabe",
            "title_en" => "Le titre de la section est en anglais",
            "show" => "Voir la section Politique de confidentialité",
            "edit" => "Modifier la section politique de confidentialité",
            "delete_modal" => [
                "title" => "Supprimer la section politique de confidentialité",
                "description" =>
                    "Voulez-vous supprimer la section politique de confidentialité ?",
            ],
            "delete" => "Supprimer la section politique de confidentialité",
            "paragraph_ar" => "Section Description Arabe",
            "paragraph_en" => "Description de la section Français",
        ],
        "usage-agreement" => [
            'title' => 'Titre de la section',
            'paragraphe' => 'Description de la partie',
            "page-title" => "Gérer la page d'accord d'utilisation",
            "create" => "Ajouter une section du contrat d'utilisation",
            "search" => "recherche",
            "title_ar" => "Le titre de la section est en arabe",
            "title_en" => "Le titre de la section est en anglais",
            "show" => "Consulter la section Conditions d'utilisation",
            "edit" => "Modification de la section Contrat d'utilisation",
            "delete_modal" => [
                "title" => "Supprimer la section Conditions d'utilisation",
                "description" =>
                    "Voulez-vous supprimer la section du contrat d'utilisation ?",
            ],
            "delete" => "Supprimer la section Conditions d'utilisation",
            "paragraph_ar" => "Section Description Arabe",
            "paragraph_en" => "Description de la section Français",
        ],
    ],
    "qnas" => [
        "question" => 'Foire aux questions',
            "answer"=>'réponse à une question fréquemment posée',
        "title" => "questions courantes",
        "single_title" => "question",
        "all_products" => "Tous les produits",
        "manage_qnas" => "Gestion des questions fréquemment posées",
        "id" => "Identifiant de la question",
        "name_ar" => "nom arabe",
        "name_en" => "Le nom est en anglais",
        "desc_ar" => "Description d'une question en arabe",
        "desc_en" => "Description de la question en anglais",
        "is_featured" => "Produit en vedette",
        "is_active" => "la condition",
        "active" => "actif",
        "inactive" => "Inactif",
        "price" => "le prix",
        "unitPrice" => "prix unitaire",
        "total" => "Prix total des questions",
        "order" => "classement",
        "category" => "Section",
        "vendor" => "la boutique",
        "pending" => "mon voisin",
        "in_review" => "en cours d'évaluation",
        "holded" => "suspendu",
        "yes" => "Oui",
        "no" => "Non",
        "create" => "Créer une nouvelle question",
        "update" => "Modifier une question",
        "search" => "recherche",
        "all" => "tout le monde",
        "filter" => "filtration",
        "created_at_select" => "Choisissez une date",
        "not_found" => "rien",
        "show" => "une offre",
        "delete" => "supprimer",
        "edit" => "amendement",
        "vendor_id" => "la boutique",
        "arabic_date" => "Données arabes",
        "english_date" => "Données en anglais",
        "choose_category" => "Choisissez un département",
        "image" => "Choisissez l'image de la question",
        "image_title" => "Faites glisser l'image de la question ici",
        "answer_ar" => "La réponse est en arabe",
        "answer_en" => "La réponse est en anglais",
        "question_en" => "La question est en anglais",
        "question_ar" => "La question est en arabe",
        "delete_modal" => [
            "title" => "Vous êtes sur le point de supprimer une question",
            "description" =>
                "La suppression de votre demande supprimera toutes les informations relatives à cette question.",
        ],
        "validations" => [
            "question_ar_required" => "La question est obligatoire",
            "question_ar_string" => "La question doit être du texte",
            "question_ar_min" =>
                "La question doit comporter au moins 3 lettres",
            "question_ar_max" =>
                "La question doit comporter au maximum 600 caractères",
            "answer_ar_required" => "La réponse s'impose",
            "answer_ar_string" => "La réponse doit être du texte",
            "answer_ar_min" => "La réponse doit comporter au moins 3 lettres",
            "answer_ar_max" =>
                "La réponse doit comporter au maximum 1000 caractères",
            "question_en_required" => "La question est obligatoire",
            "question_en_string" => "La question doit être du texte",
            "question_en_min" =>
                "La question doit comporter au moins 3 lettres",
            "question_en_max" =>
                "La question doit comporter au maximum 600 caractères",
            "answer_en_required" => "La réponse s'impose",
            "answer_en_string" => "La réponse doit être du texte",
            "answer_en_min" => "La réponse doit comporter au moins 3 lettres",
            "answer_en_max" =>
                "La réponse doit comporter au maximum 1000 caractères",
        ],
        "messages" => [
            "created_successfully_title" => "Question créée avec succès",
            "created_successfully_body" => "Question créée avec succès",
            "created_error_title" =>
                "Erreur lors de la création de la question",
            "created_error_body" =>
                "Une erreur s'est produite lors de la création de la question",
            "updated_successfully_title" => "Question modifiée avec succès",
            "updated_successfully_body" => "Question modifiée avec succès",
            "updated_error_title" =>
                "Erreur lors de la modification de la question",
            "updated_error_body" =>
                "Une erreur s'est produite lors de la modification de la question",
            "deleted_successfully_title" =>
                "La question a été supprimée avec succès",
            "deleted_successfully_message" =>
                "La question a été supprimée avec succès",
            "deleted_error_title" =>
                "Erreur lors de la suppression de la question",
            "deleted_error_message" =>
                "Une erreur s'est produite lors de la suppression de la question",
        ],
    ],
    "rates_title" => "Évaluation",
    "no_data" => "rien",
    "admin_approved_state" => [
        "pending" => "Approbation en cours",
        "approved" => "D'ACCORD",
        "rejected" => "inacceptable",
    ],
    "productRates" => [
        "last_admin_edit" =>
            "Date de la dernière modification par l'administrateur",
        "title" => "Évaluation des produits",
        "single_title" => "Évaluation du produit",
        "all_productRates" => "Tous les avis produits",
        "manage_productRates" => "Gérer les avis produits",
        "state_apporved" => "Il a été accepté",
        "state_not_apporved" => "Pas accepté",
        "id" => "Identifiant d'évaluation",
        "rate" => "Évaluation",
        "comment" => "Commentaire client",
        "user_id" => "nom du client",
        "product_id" => "nom du produit",
        "reason" => "la raison",
        "admin_id" => "Nom de l'administrateur",
        "admin_comment" => "Commentaire de l'administrateur",
        "admin_approved" => "Statut approuvé",
        "reporting" => "Notification",
        "yes" => "Oui",
        "no" => "Non",
        "update" => "Modifier les données d'évaluation",
        "search" => "recherche",
        "all" => "tout le monde",
        "filter" => "filtration",
        "not_found" => "rien",
        "show" => "Afficher les données d'évaluation",
        "delete" => "supprimer",
        "active" => "actif",
        "inactive" => "pas actif",
        "filter_is_active" => "Filtrer par statut",
        "not_answer" => "L'administrateur n'a pas encore approuvé",
        "choose_state" => "Sélectionnez le statut d'évaluation",
        "delete_modal" => [
            "title" => "Vous êtes sur le point de supprimer un avis produit",
            "description" =>
                "La suppression de votre candidature supprimera toutes vos informations de notre base de données.",
        ],
        "messages" => [
            "created_successfully_title" => "Évaluation créée avec succès",
            "created_successfully_body" => "Évaluation créée avec succès",
            "created_error_title" =>
                "Erreur lors de la création de l'évaluation",
            "created_error_body" =>
                "Une erreur s'est produite lors de la création de l'évaluation",
            "updated_successfully_title" =>
                "La note a été modifiée avec succès",
            "updated_successfully_body" => "La note a été modifiée avec succès",
            "updated_error_title" =>
                "Erreur lors de la modification de la note",
            "updated_error_body" =>
                "Une erreur s'est produite lors de la modification de la note",
            "deleted_successfully_title" =>
                "La note a été supprimée avec succès",
            "deleted_successfully_message" =>
                "La note a été supprimée avec succès",
            "deleted_error_title" => "Erreur lors de la suppression de la note",
            "deleted_error_message" =>
                "Une erreur s'est produite lors de la suppression de la note",
        ],
        "validations" => [
            "admin_comment_string" =>
                "Le commentaire de l'administrateur doit être de type texte",
            "admin_comment_min" =>
                "Le nombre minimum de caractères pour un commentaire d'administrateur est de 3 lettres",
            "admin_approved_boolean" =>
                "Le type de champ de ce champ doit être une valeur booléenne",
            "admin_id_numeric" =>
                "Le type de champ de ce champ doit être une valeur booléenne",
        ],
    ],
    "vendorRates" => [
        "last_admin_edit" =>
            "Date de la dernière modification par l'administrateur",
        "title" => "Évaluation du magasin",
        "single_title" => "Évaluation du marchand",
        "all_vendorRates" => "Toutes les évaluations des magasins",
        "manage_vendorRates" => "Gestion des notes des magasins",
        "state_apporved" => "Il a été accepté",
        "state_not_apporved" => "Pas accepté",
        "id" => "Identifiant d'évaluation",
        "rate" => "Évaluation",
        "comment" => "Commentaire client",
        "user_id" => "nom du client",
        "vendor_id" => "Nom du commerçant",
        "admin_id" => "Nom de l'administrateur",
        "admin_comment" => "Commentaire de l'administrateur",
        "admin_approved" => "Statut approuvé",
        "yes" => "Oui",
        "no" => "Non",
        "update" => "Modifier les données d'évaluation",
        "search" => "recherche",
        "all" => "tout le monde",
        "filter" => "filtration",
        "not_found" => "rien",
        "show" => "Afficher les données d'évaluation",
        "delete" => "supprimer",
        "active" => "actif",
        "inactive" => "pas actif",
        "filter_is_active" => "Filtrer par statut",
        "not_answer" => "L'administrateur n'a pas encore approuvé",
        "choose_state" => "Sélectionnez le statut d'évaluation",
        "delete_modal" => [
            "title" =>
                "Vous êtes sur le point de supprimer une note de marchand",
            "description" =>
                "La suppression de votre candidature supprimera toutes vos informations de notre base de données.",
        ],
        "messages" => [
            "created_successfully_title" => "Évaluation créée avec succès",
            "created_successfully_body" => "Évaluation créée avec succès",
            "created_error_title" =>
                "Erreur lors de la création de l'évaluation",
            "created_error_body" =>
                "Une erreur s'est produite lors de la création de l'évaluation",
            "updated_successfully_title" =>
                "La note a été modifiée avec succès",
            "updated_successfully_body" => "La note a été modifiée avec succès",
            "updated_error_title" =>
                "Erreur lors de la modification de la note",
            "updated_error_body" =>
                "Une erreur s'est produite lors de la modification de la note",
            "deleted_successfully_title" =>
                "La note a été supprimée avec succès",
            "deleted_successfully_message" =>
                "La note a été supprimée avec succès",
            "deleted_error_title" => "Erreur lors de la suppression de la note",
            "deleted_error_message" =>
                "Une erreur s'est produite lors de la suppression de la note",
        ],
        "validations" => [
            "admin_comment_string" =>
                "Le commentaire de l'administrateur doit être de type texte",
            "admin_comment_min" =>
                "Le nombre minimum de caractères pour un commentaire d'administrateur est de 3 lettres",
            "admin_approved_boolean" =>
                "Le type de champ de ce champ doit être une valeur booléenne",
            "admin_id_numeric" =>
                "Le type de champ de ce champ doit être une valeur booléenne",
        ],
    ],
    "recipes" => [
        "body" => "contenu",
        'short_desc'=>'description courte',
        "title" => "recettes",
        "single_title" => "la recette",
        "all_recipes" => "Toutes les recettes",
        "manage_recipes" => "Gestion des ordonnances",
        "id" => "Identifiant de la recette",
        "body_ar" => "Contenu arabe",
        "body_en" => "Contenu en anglais",
        "image" => "Choisissez une image de description",
        "most_visited" => "le plus visité",
        "image_for_show" => "Photo de recette",
        "is_active" => "la condition",
        "yes" => "Oui",
        "no" => "Non",
        "create" => "Créer une nouvelle recette",
        "update" => "Modification de recette",
        "search" => "recherche",
        "all" => "tout le monde",
        "filter" => "filtration",
        "not_found" => "rien",
        "show" => "Afficher les données de recette",
        "edit" => "amendement",
        "delete" => "supprimer",
        "active" => "actif",
        "inactive" => "pas actif",
        "filter_is_active" => "Filtrer par statut",
        "choose_state" => "Sélectionnez l'état de la recette",
        "choose_country" => "Sélectionnez la recette",
        "country_id" => "la recette",
        "areas_cities" => "Les quartiers de la ville",
        "title_ar" => "L'adresse est arabe",
        "title_en" => "L'adresse est en anglais",
        "short_desc_ar" => "La courte description est en arabe",
        "short_desc_en" => "La courte description est en anglais",
        "delete_modal" => [
            "title" => "Vous êtes sur le point de supprimer une recette ?",
            "description" =>
                "La suppression de votre candidature supprimera toutes vos informations de notre base de données.",
        ],
        "messages" => [
            "created_successfully_title" => "Recette générée avec succès",
            "created_successfully_body" => "Recette générée avec succès",
            "created_error_title" => "Erreur lors de la création de la recette",
            "created_error_body" =>
                "Une erreur s'est produite lors de la création de la recette",
            "updated_successfully_title" =>
                "La recette a été modifiée avec succès",
            "updated_successfully_body" =>
                "La recette a été modifiée avec succès",
            "updated_error_title" =>
                "Erreur lors de la modification de la recette",
            "updated_error_body" =>
                "Une erreur s'est produite lors de la modification de la recette",
            "deleted_successfully_title" =>
                "La recette a été supprimée avec succès",
            "deleted_successfully_message" =>
                "La recette a été supprimée avec succès",
            "deleted_error_title" =>
                "Erreur lors de la suppression de la recette",
            "deleted_error_message" =>
                "Une erreur s'est produite lors de la suppression de la recette",
        ],
        "validations" => [
            "title_ar_required" => "Titre en arabe obligatoire",
            "title_en_required" => "Le titre en anglais est requis",
            "title_ar_min" => "Le titre doit comporter au moins 3 caractères",
            "title_en_min" => "Le titre doit comporter au moins 3 caractères",
            "title_ar_max" =>
                "Le titre doit comporter au maximum 600 caractères",
            "title_en_max" =>
                "Le titre doit comporter au maximum 600 caractères",
            "body_ar_required" => "Le contenu en arabe est requis",
            "body_en_required" => "Le contenu en anglais est requis",
            "short_desc_ar_required" =>
                "Une courte description en arabe est requise",
            "short_desc_en_required" =>
                "Une courte description en anglais est requise",
            "short_desc_ar_min" =>
                "La description doit comporter au moins 3 caractères",
            "short_desc_en_min" =>
                "La description doit comporter au moins 3 caractères",
            "body_ar_max" =>
                "La description ne doit pas dépasser 1 000 caractères",
            "body_en_max" =>
                "La description ne doit pas dépasser 1 000 caractères",
        ],
    ],
    "blogPosts" => [
        "body" => "contenu",
        'short_desc'=>'description courte',
        "title" => "Blog",
        "single_title" => "Fils",
        "all_recipes" => "Toutes les recettes",
        "manage_blogPosts" => "Gestion du blog",
        "id" => "Identifiant de la recette",
        "body_ar" => "Contenu arabe",
        "body_en" => "Contenu en anglais",
        "image" => "Choisissez une image de description",
        "most_visited" => "le plus visité",
        "image_for_show" => "Photo de recette",
        "is_active" => "la condition",
        "yes" => "Oui",
        "no" => "Non",
        "create" => "Créer un nouveau sujet",
        "update" => "Modifier un thème",
        "search" => "recherche",
        "all" => "tout le monde",
        "filter" => "filtration",
        "not_found" => "rien",
        "show" => "Afficher les données du sujet",
        "edit" => "amendement",
        "delete" => "supprimer",
        "active" => "actif",
        "inactive" => "pas actif",
        "filter_is_active" => "Filtrer par statut",
        "choose_state" => "Choisissez un cas thématique",
        "choose_country" => "Choisir un sujet",
        "country_id" => "Thème",
        "areas_cities" => "Les quartiers de la ville",
        "title_ar" => "L'adresse est arabe",
        "title_en" => "L'adresse est en anglais",
        "short_desc_ar" => "La courte description est en arabe",
        "short_desc_en" => "La courte description est en anglais",
        "delete_modal" => [
            "title" => "Vous êtes sur le point de supprimer un sujet ?",
            "description" =>
                "La suppression de votre candidature supprimera toutes vos informations de notre base de données.",
        ],
        "messages" => [
            "created_successfully_title" => "Sujet créé avec succès",
            "created_successfully_body" => "Sujet créé avec succès",
            "created_error_title" => "Erreur lors de la création du sujet",
            "created_error_body" =>
                "Une erreur s'est produite lors de la création du sujet",
            "updated_successfully_title" => "Le fil a été modifié avec succès",
            "updated_successfully_body" => "Le fil a été modifié avec succès",
            "updated_error_title" => "Erreur lors de la modification du sujet",
            "updated_error_body" =>
                "Une erreur s'est produite lors de la modification du thème",
            "deleted_successfully_title" =>
                "Le sujet a été supprimé avec succès",
            "deleted_successfully_message" =>
                "Le sujet a été supprimé avec succès",
            "deleted_error_title" => "Erreur lors de la suppression du sujet",
            "deleted_error_message" =>
                "Une erreur s'est produite lors de la suppression du sujet",
        ],
        "validations" => [
            "title_ar_required" => "Titre en arabe obligatoire",
            "title_en_required" => "Le titre en anglais est requis",
            "title_ar_min" => "Le titre doit comporter au moins 3 caractères",
            "title_en_min" => "Le titre doit comporter au moins 3 caractères",
            "body_ar_required" => "Le contenu en arabe est requis",
            "body_en_required" => "Le contenu en anglais est requis",
            "short_desc_ar_required" =>
                "Une courte description en arabe est requise",
            "short_desc_en_required" =>
                "Une courte description en anglais est requise",
            "short_desc_ar_min" =>
                "La description doit comporter au moins 3 caractères",
            "short_desc_en_min" =>
                "La description doit comporter au moins 3 caractères",
        ],
    ],
    "productQuantities" => [
        "name"=>"le nom",
        "title" => "Unités de mesure du produit",
        "single_title" => "unité de mesure",
        "all_cities" => "Toutes les unités de mesure",
        "manage_productQuantities" => "Gérer les unités de mesure des produits",
        "id" => "Identifiant de l'unité",
        "name_ar" => "nom arabe",
        "name_en" => "Le nom est en anglais",
        "is_active" => "la condition",
        "yes" => "Oui",
        "no" => "Non",
        "create" => "Créer une nouvelle unité",
        "update" => "Modifier seul",
        "search" => "recherche",
        "all" => "tout le monde",
        "filter" => "filtration",
        "not_found" => "rien",
        "show" => "Afficher les données de l'unité",
        "delete" => "supprimer",
        "active" => "actif",
        "inactive" => "pas actif",
        "filter_is_active" => "Filtrer par statut",
        "choose_state" => "Sélectionnez l'état de l'unité",
        "delete_modal" => [
            "title" => "Vous êtes sur le point de supprimer seul",
            "description" =>
                "La suppression de votre candidature supprimera toutes vos informations de notre base de données.",
        ],
        "messages" => [
            "created_successfully_title" => "L'unité a été créée avec succès",
            "created_successfully_body" => "L'unité a été créée avec succès",
            "created_error_title" => "Erreur lors de la création de l'unité",
            "created_error_body" =>
                "Une erreur s'est produite lors de la création du module",
            "updated_successfully_title" =>
                "L'unité a été modifiée avec succès",
            "updated_successfully_body" => "L'unité a été modifiée avec succès",
            "updated_error_title" =>
                "Erreur lors de la modification de l'unité",
            "updated_error_body" =>
                "Une erreur s'est produite lors de la modification du module",
            "deleted_successfully_title" =>
                "L'unité a été supprimée avec succès",
            "deleted_successfully_message" =>
                "L'unité a été supprimée avec succès",
            "deleted_error_title" => "Erreur lors de la suppression de l'unité",
            "deleted_error_message" =>
                "Une erreur s'est produite lors de la suppression du module",
        ],
        "validations" => [
            "name_ar_required" => "Le nom de l'unité en arabe est obligatoire",
            "name_ar_string" =>
                "Le nom du module arabe doit être de type String",
            "name_ar_min" =>
                "Le nombre minimum de lettres dans le nom de l'unité arabe est d'au moins 3 lettres",
            "name_en_required" => "Le nom de l'unité en anglais est requis",
            "name_en_string" =>
                "Le nom du module anglais doit être de type chaîne",
            "name_en_min" =>
                "Le plus petit nombre de lettres dans le nom de l'unité anglaise est d'au moins 3 lettres",
            "country_id_required" => "L'état est obligatoire",
            "is_active_required" => "Le statut est requis",
        ],
    ],
    "wareHouseRequests" => [
        "title" => "demandes de stockage",
        "single_title" => "Triste demande",
        "all_wareHouseRequests" => "Toutes les demandes de stockage",
        "manage_wareHouseRequests" => "Gérer les demandes de stockage",
        "products_count" => "Le nombre de produits",
        "id" => "numéro de commande",
        "next" => "le suivant",
        "vendor" => "la boutique",
        "choose_vendor" => "Sélectionnez le magasin",
        "choose_product" => "Sélectionnez le produit",
        "name_ar" => "Nom du produit en arabe",
        "name_en" => "Nom du produit en anglais",
        "product" => "le produit",
        "status" => "la condition",
        "created_at" => "Date créée",
        "created_by" => "par",
        "qnt" => "Le nombre de noyaux",
        "mnfg_date" => "Date de production",
        "expire_date" => "Date d'expiration",
        "yes" => "Oui",
        "no" => "Non",
        "create" => "Créer une nouvelle demande de stockage",
        "update" => "Modifier une demande de stockage",
        "search" => "recherche",
        "all" => "tout le monde",
        "filter" => "filtration",
        "not_found" => "rien",
        "show" => "Afficher les données de demande de stockage",
        "delete" => "supprimer",
        "active" => "actif",
        "inactive" => "pas actif",
        "filter_is_active" => "Filtrer par statut",
        "choose_state" => "Choisir le statut de la demande de stockage",
        "requestItems" => "des produits",
        "vendor-no-products" =>
            "Ce marchand n'a pas de produits, veuillez choisir un autre marchand",
        "product_count" => "nombre de produits",
        "delete_modal" => [
            "title" =>
                "Vous êtes sur le point de supprimer une demande de stockage",
            "description" =>
                "La suppression de votre candidature supprimera toutes vos informations de notre base de données.",
        ],
        "messages" => [
            "created_successfully_title" =>
                "Une demande de stockage a été créée avec succès",
            "created_successfully_body" =>
                "Une demande de stockage a été créée avec succès",
            "created_error_title" =>
                "Erreur lors de la création de la demande de stockage",
            "created_error_body" =>
                "Une erreur s'est produite lors de la création d'une demande de stockage",
            "updated_successfully_title" =>
                "Une demande de stockage a été modifiée avec succès",
            "updated_successfully_body" =>
                "Une demande de stockage a été modifiée avec succès",
            "updated_error_title" =>
                "Erreur lors de la modification de la demande de stockage",
            "updated_error_body" =>
                "Une erreur s'est produite lors de la modification d'une demande de stockage",
            "deleted_successfully_title" =>
                "Une demande de stockage a été supprimée avec succès",
            "deleted_successfully_message" =>
                "Une demande de stockage a été supprimée avec succès",
            "deleted_error_title" =>
                "Erreur lors de la suppression d'une demande de stockage",
            "deleted_error_message" =>
                "Une erreur s'est produite lors de la suppression d'une demande de stockage",
        ],
        "validations" => [
            "vendor_id_required" => "Le nom du magasin est requis",
            "product_id_required" =>
                "Le nom de la demande de stockage en arabe est requis",
            "qnt_required" =>
                "Le nom de la demande de stockage en arabe doit être de type chaîne",
            "mnfg_date_required" =>
                "Le nombre minimum de lettres pour le nom de la demande de stockage en arabe est d'au moins 3 lettres",
            "expire_date_required" =>
                "Le nom de la demande de stockage en anglais est requis",
            "expire_date_after" =>
                "La date de péremption doit être postérieure à la date de production",
        ],
    ],
    "sliders" => [
        "manage_sliders" => "Gestion des curseurs",
        "name" => "le nom",
        "identifire" => "Nom d'identification",
        "id" => "IDENTIFIANT",
        "type" => "Taper",
        "show" => "une offre",
        "edit" => "amendement",
        "image" => "Ajouter une image",
        "create" => "Créer un curseur",
        "remove" => "esprit",
        "delete" => "annulation",
        "identifier" => "IDENTIFIANT",
        "delete_modal" => [
            "title" =>
                "Vous êtes sur le point de supprimer une demande de stockage",
            "description" =>
                "La suppression de votre candidature supprimera toutes vos informations de notre base de données.",
        ],
        "messages" => [
            "created_successfully_title" => "Le curseur a été ajouté",
            "created_successfully_body" => "Le curseur a été ajouté",
            "updated_successfully_title" => "Le curseur a été modifié",
            "updated_successfully_body" => "Le curseur a été modifié",
            "deleted_successfully_title" =>
                "L'image a été supprimée avec succès",
            "deleted_successfully_message" =>
                "L'image a été supprimée avec succès",
        ],
    ],
    "carts_list" => "Acheter des paniers",
    "cart_show" => "Voir le panier",
    "cart_main_details" => "Données du panier principal",
    "cart_id" => "ID du panier",
    "cart_date" => "La date de création du panier",
    "cart_price" => "le prix",
    "cart_products_count" => "nombre de produits",
    "cart_customer_name" => "nom du client",
    "cart_last_update" => "La date de la dernière mise à jour",
    "team_title" => "équipe de travail",
    "unauthorized_title" => "Vous n'avez pas de validité",
    "unauthorized_body" => "Désolé... Vous n'avez pas de validité",
    "subAdmins" => [
        "title" => "Administrateurs système",
        "single_title" => "Administrateur du système",
        "manage_subAdmins" => "Gestion des administrateurs système",
        "rules" => "Rôles de superviseur",
        "yes" => "Oui",
        "no" => "Non",
        "id" => "ID de superviseur",
        "name" => "le nom",
        "email" => "E-mail",
        "phone" => "téléphone portable",
        "password" => "mot de passe",
        "no_rules_found" => "Il n'y a actuellement aucun rôle",
        "avatar" => "photo d'utilisateur",
        "create" => "Créer un nouveau superviseur",
        "edit" => "amendement",
        "update" => "Modification du modérateur",
        "search" => "recherche",
        "all" => "tout le monde",
        "filter" => "filtration",
        "not_found" => "rien",
        "show" => "Afficher les données d'administration",
        "delete" => "supprimer",
        "delete_modal" => [
            "title" => "Vous êtes sur le point de supprimer un administrateur",
            "description" =>
                "La suppression de votre candidature supprimera toutes vos informations de notre base de données.",
        ],
        "messages" => [
            "created_successfully_title" => "Superviseur créé avec succès",
            "created_successfully_body" => "Superviseur créé avec succès",
            "created_error_title" =>
                "Erreur lors de la création de l'administrateur",
            "created_error_body" =>
                "Une erreur s'est produite lors de la création d'un administrateur",
            "updated_successfully_title" =>
                "L'administrateur a été modifié avec succès",
            "updated_successfully_body" =>
                "L'administrateur a été modifié avec succès",
            "updated_error_title" =>
                "Erreur lors de la modification de l'administrateur",
            "updated_error_body" =>
                "Une erreur s'est produite lors de la modification d'un administrateur",
            "deleted_successfully_title" =>
                "Le superviseur a été supprimé avec succès",
            "deleted_successfully_message" =>
                "Le superviseur a été supprimé avec succès",
            "deleted_error_title" =>
                "Erreur lors de la suppression de l'administrateur",
            "deleted_error_message" =>
                "Une erreur s'est produite lors de la suppression d'un administrateur",
        ],
        "validations" => [
            "name_required" => "Le champ Nom est obligatoire",
            "name_string" => "Le champ Nom doit être une chaîne",
            "name_min" =>
                "Le nombre minimum de lettres dans le nom est de 3 lettres",
            "email_required" => "Le champ e-mail est obligatoire",
            "email_email" => "Format d'e-mail incorrect",
            "email_unique" => "L'affranchissement a déjà été pris",
            "phone_required" => "Le numéro de portable est requis",
            "phone_min" =>
                "La longueur minimale d'un numéro de mobile est de 9 chiffres",
            "password_required" => "Le champ mot de passe est obligatoire",
            "password_string" =>
                "Le mot de passe doit être une chaîne de texte",
            "password_min" =>
                "La longueur minimale du mot de passe est de 8 caractères ou chiffres",
            "avatar_image" => "Format d'image invalide",
            "avatar_mimes" => "L'extension d'image autorisée est png, jpeg",
        ],
    ],
    "rules" => [
        "title" => "Je tourne les modérateurs",
        "single_title" => "rôle",
        "all_rules" => "Tous les rôles",
        "manage_rules" => "Gestion des rôles",
        "id" => "ID de rôle",
        "name_ar" => "nom arabe",
        "name_en" => "Le nom est en anglais",
        "yes" => "Oui",
        "no" => "Non",
        "create" => "Créer un nouveau rôle",
        "update" => "Modification de rôle",
        "search" => "recherche",
        "all" => "tout le monde",
        "filter" => "filtration",
        "not_found" => "rien",
        "show" => "Afficher les données de rôle",
        "delete" => "supprimer",
        "sub-admin" => "Administration",
        "vendor" => "la boutique",
        "choose_scope" => "Choisissez un domaine",
        "choose_scope_filter" => "Étendue du filtre de rôle",
        "scope" => "la gamme",
        "permissions" => [
            "title" => "Tous les permis",
            "no_permissions_found" => "Il n'y a pas de permis",
        ],
        "delete_modal" => [
            "title" => "Vous êtes sur le point de supprimer pixelisé",
            "description" =>
                "La suppression de votre candidature supprimera toutes vos informations de notre base de données.",
        ],
        "messages" => [
            "created_successfully_title" => "Le rôle a été créé avec succès",
            "created_successfully_body" => "Le rôle a été créé avec succès",
            "created_error_title" => "Erreur lors de la création du rôle",
            "created_error_body" =>
                "Une erreur s'est produite lors de la création du rôle",
            "updated_successfully_title" => "Le rôle a été modifié avec succès",
            "updated_successfully_body" => "Le rôle a été modifié avec succès",
            "updated_error_title" => "Erreur lors de la modification du rôle",
            "updated_error_body" =>
                "Une erreur s'est produite lors de la modification du rôle",
            "deleted_successfully_title" =>
                "Le rôle a été supprimé avec succès",
            "deleted_successfully_message" =>
                "Le rôle a été supprimé avec succès",
            "deleted_error_title" => "Erreur lors de la suppression du rôle",
            "deleted_error_message" =>
                "Une erreur s'est produite lors de la suppression du rôle",
        ],
        "validations" => [
            "name_ar_required" => "Le nom du rôle en arabe est requis",
            "name_ar_string" =>
                "Le nom de rôle arabe doit être un type de chaîne",
            "name_ar_min" =>
                "Le nombre minimum de lettres dans le nom arabe Dur est d'au moins 3 lettres",
            "name_en_required" => "Le nom du rôle en anglais est requis",
            "name_en_string" =>
                "Le nom du rôle en anglais doit être une chaîne",
            "name_en_min" =>
                "Le plus petit nombre de lettres dans le nom de rôle anglais est d'au moins 3 lettres",
            "scope_required" => "Le domaine est requis",
            "permissions_required" =>
                "Au moins un permis doit être sélectionné",
            "permissions_array" =>
                "Le type de champ d'autorisation doit être un tableau",
            "permissions_present" => "Les permis doivent contenir au moins un",
        ],
    ],
    "certificates" => "Témoignages",
    "certificate_title" => "Nom du certificat",
    "certificate_image" => "Copie du certificat",
    "certificate_requests" => "Demandes de certification",
    "certificate_edit" => "Modifier le certificat",
    "certificate_please_enter_title" =>
        "Veuillez entrer le titre du certificat",
    "certificate_please_enter_image" =>
        "Veuillez entrer une copie du certificat",
    "certificate_download" => "Télécharger le certificat",
    "certificate_request_vendor" => "marchand",
    "certificate_request_file" => "Fichier de certificat",
    "certificate_request_expire" => "Date d'expiration du certificat",
    "certificate_approve" => "Le certificat a été approuvé",
    "certificate_reject" => "Le certificat a été rejeté",
    "certificates_number" => "Le nombre de certificats",
    "no_certificates" => "Il n'y a pas de témoignages",
    "certificates_create" => "Créer un certificat",
    "certificates_edit" => "certificat modifier",
    "vendors_info" => [
        "vendor_name_ar" => "Le nom du magasin est arabe",
        "vendor_name_en" => "Le nom du magasin est anglais",
        "validations" => [
            "vendor_name_ar" => "Le champ du nom arabe est obligatoire",
            "commission_required" =>
                "Le pourcentage de gestion du prix de vente est requis",
            "commission_gte" =>
                "Le ratio de gestion du prix de vente est supérieur ou égal à ",
            "vendor_name_en" => "Le champ du nom anglais est obligatoire",
        ],
    ],
    "vendorWallets" => [
        "in" => "ajout",
        "out" => "rival",
        "all_wallets" => "Tous les comptes",
        "vendor_name" => "Nom du magasin",
        "vendor_name_ar" => "Le nom du magasin est arabe",
        "vendor_name_en" => "Le nom du magasin est anglais",
        "user_vendor_name" => "Nom du propriétaire du magasin",
        "show" => "une offre",
        "sub_balance" => "Déduction de crédit magasin",
        "id" => "identifiant de compte",
        "manage" => "Gestion du portefeuille magasins",
        "import" => "Importer des comptes",
        "search" => "Rechercher des comptes",
        "title" => "Comptes de magasin",
        "single_title" => "Compte magasins",
        "customer_name" => "Nom du magasin",
        "attachments" => "pièces jointes",
        "no_attachments" => "Il n'y a pas de pièces jointes",
        "by_admin" => "par",
        "is_active" => "statut d'activation",
        "last_update" => "Dernière mise à jour",
        "active" => "actif",
        "inactive" => "pas actif",
        "choose_state" => "Choisissez le statut du compte",
        "choose_customer" => "Choisissez un marchand",
        "amount" => "équilibre",
        "reason" => "la raison",
        "created_at" => "La date de création du compte",
        "created_at_select" => "Choisissez une date",
        "all" => "tout le monde",
        "filter" => "filtration",
        "attachemnts" => "Télécharger la pièce jointe",
        "no_result_found" => "Aucun résultat trouvé",
        "attachment" => "pièces jointes",
        "has_attachment" => "Aperçu de la pièce jointe",
        "has_no_attachment" => "Il n'y a pas de pièces jointes",
        "change_status" => "Changer le statut du compte",
        "manage_wallet_balance" => "Gestion du solde du compte",
        "current_wallet_balance" => "solde du compte courant",
        "subtract" => "rival",
        "wallet_balance" => "solde du compte",
        "wallets_transactions" => [
            "title" => "Opérations sur compte",
            "single_title" => "transaction de compte",
            "customer_name" => "Nom du magasin",
            "wallet_id" => "identifiant de compte",
            "amount" => "Le montant de la transaction",
            "transaction_date" => "Date de la transaction",
        ],
        "messages" => [
            "created_successfully_title" => "Nouveau compte marchand",
            "created_successfully_body" =>
                "Un nouveau compte marchand a été créé avec succès",
            "created_error_title" => "La création du compte marchand a échoué",
            "created_error_body" =>
                "La création d'un nouveau compte marchand a échoué",
            "updated_successfully_title" =>
                "Modifier le statut du compte marchand",
            "updated_successfully_body" =>
                "Statut du compte marchand modifié avec succès",
            "updated_error_title" =>
                "Échec de la modification du statut du compte marchand",
            "updated_error_body" =>
                "Échec de l'ajustement de l'état du compte marchand",
            "customer_has_wallet_title" =>
                "Il n'est pas possible de créer un compte pour cette boutique",
            "customer_has_wallet_message" =>
                "Il n'est pas possible de créer un compte pour ce magasin car il en a déjà un",
        ],
        "customer_info" => [
            "email" => "Poster",
            "phone" => "téléphone portable",
        ],
        "transaction" => [
            "title" => "Gestion du solde du compte",
            "wallet_transactions_log" =>
                "Historique des transactions du compte",
            "id" => "identifiant de transaction",
            "type" => "Type d'opération",
            "receipt_url" => "Facilité d'exploitation",
            "operation_type" => "Choisissez le type d'opération",
            "reference" => "Réf",
            "reference_id" => "numéro de réference",
            "admin_by" => "par l'administrateur",
            "amount" => "Valeur transactionnelle",
            "date" => "Date de la transaction",
            "add" => "Ajouter +",
            "sub" => "rival -",
            "receipt" => "pièces jointes",
            "success_add_title" => "Processus d'ajout de crédit réussi",
            "success_add_message" =>
                "La carte du commerçant a été créditée avec succès",
            "success_sub_title" => "Déduction de crédit réussie",
            "success_sub_message" =>
                "Le solde de la carte du commerçant a été débité avec succès",
            "fail_add_title" => "Échec de l'ajout de crédit",
            "fail_add_message" =>
                "Le crédit de la carte du commerçant a échoué",
            "fail_sub_title" => "Échec de la déduction du solde",
            "fail_sub_message" => "Échec du débit de la carte du commerçant",
            "cannot_subtract_message" =>
                "Le solde de la carte est inférieur aux valeurs de remise",
            "user_id" => "Le processus a été fait par",
            "order_code" => "code requis",
            "transaction_type" => [
                "title" => "Type d'opération",
                "choose_transaction_type" => "Choisissez le type d'opération",
                "purchase" => "acheter des produits",
                "gift" => "cadeau",
                "bank_transfer" => "virement",
                "compensation" => "compensation",
            ],
            "opening_balance" => "Solde d'ouverture",
            "validations" => [
                "amount_required" =>
                    "Le champ de la valeur de la transaction est obligatoire",
                "amount_numeric" =>
                    "La valeur de la transaction doit être une valeur numérique",
                "receipt_url_required" =>
                    "Le champ Type de transaction est obligatoire",
                "receipt_url_image" =>
                    "Vous devez sélectionner le type de transaction",
            ],
        ],
        "vendors_finances" => "Finances du magasin",
        "select-option" => "Choisir",
    ],
    "settings" => [
        "main" => "Paramètres",
        "show" => "une offre",
        "id" => "IDENTIFIANT",
        "key" => "le nom",
        "value" => "la valeur",
        "manage_settings" => "Gestion des paramètres",
        "edit" => "amendement",
        "validations" => [
            "pdf" => "Le fichier doit être un PDF",
        ],
        "messages" => [
            "setting-not-editable" => "Ce paramètre ne peut pas être modifié",
            "updated_successfully_title" => "Modifier la valeur",
            "updated_error_title" => "La modification de la valeur a échoué",
            "updated_successfully_body" =>
                "La valeur a été modifiée avec succès",
            "updated_error_body" =>
                "L'opération de modification de valeur a échoué",
        ],
    ],
    "coupons" => [
        'title'=>'Titre',
        "id" => "numéro de commande",
        "manage_coupons" => "Gestion des coupons",
        "pending" => "Je suis en attente",
        "approved" => "Activé",
        "rejected" => "désactivé",
        "messages" => [
            "created_successfully_title" => "Un nouveau coupon a été créé",
            "created_successfully_body" => "Un nouveau coupon a été créé",
            "created_error_title" => "Échec de la création d'un nouveau coupon",
            "created_error_body" => "Échec de la création d'un nouveau coupon",
            "updated_successfully_title" => "Modification du coupon",
            "updated_successfully_body" =>
                "Le coupon a été modifié avec succès",
            "updated_error_title" =>
                "La modification du coupon a échoué avec succès",
            "updated_error_body" => "Échec de la modification du coupon",
            "deleted_successfully_title" =>
                "Le coupon a été supprimé avec succès",
            "deleted_successfully_message" =>
                "Le coupon a été supprimé avec succès",
            "deleted_error_title" => "Erreur lors de la suppression du coupon",
            "deleted_error_message" =>
                "Une erreur s'est produite lors de la suppression d'un coupon",
        ],
        "coupon_type" => "Type de coupon",
        "coupon_types" => [
            "vendor" => "Rabais concessionnaire",
            "product" => "Remises sur les produits",
            "global" => "Remises générales",
            "free" => "Livraison gratuite",
        ],
        "amount" => "valeur de remise",
        "minimum_order_amount" => "Montant minimum de commande",
        "maximum_discount_amount" => "La remise maximale",
        "code" => "code",
        "maximum_redemptions_per_user" =>
            "Le nombre d'utilisations des clients",
        "maximum_redemptions_per_coupon" =>
            "Le nombre de rachat pour le coupon",
        "title_ar" => "L'adresse est arabe",
        "title_en" => "L'adresse est en anglais",
        "filter" => "recherche",
        "not_found" => "Il n'y a pas de coupons",
        "create" => "Ajouter un coupon",
        "update" => "Ajustement des coupons",
        "search" => "recherche",
        "choose_state" => "Sélectionnez le statut",
        "status" => "la condition",
        "percentage" => "taux",
        "fixed" => "montant",
        "discount_type" => "type de remise",
        "validations" => [
            "title_ar_required" => "L'adresse doit être saisie",
            "title_en_required" => "Vous devez entrer le titre en anglais",
            "title_en_max" => "supérieur à celui spécifié",
            "title_en_min" => "plus petit que spécifié",
            "code_required" => "Le code doit être saisi",
            "code_unique" => "Le code est déjà utilisé",
            "code_min" =>
                "Le nombre minimum de caractères autorisés est de 4 caractères",
            "amount_required" => "La quantité spécifiée doit être saisie",
            "amount_numeric" =>
                "La valeur de la quantité doit être une valeur numérique",
            "amount_min" => "plus petit que spécifié",
            "minimum_amount_required" =>
                "Vous devez saisir un montant minimum de commande",
            "minimum_amount_min" => "plus petit que spécifié",
            "minimum_amount_max" => "supérieur à celui spécifié",
            "minimum_amount_lt" => "Le minimum doit être inférieur au maximum",
            "amount_percentage" =>
                "Il a dépassé le pourcentage connu et il est à 100 %",
            "amount_fixed" => "Vous avez dépassé le montant",
            "coupon_type_required" => "Le type de coupon est requis",
            "vendors_required" => "Au moins un revendeur doit être sélectionné",
            "products_required" => "Au moins un produit doit être sélectionné",
            "status_required" => "Entrer le statut du coupon",
            "maximum_amount_required" =>
                "Vous devez saisir une remise maximale",
            "maximum_amount_min" => "plus petit que spécifié",
            "maximum_amount_max" => "supérieur à celui spécifié",
            "maximum_amount_gt" => "Le maximum doit être supérieur au minimum",
            "discount_type_required" => "Vous devez saisir le type de remise",
            "maximum_redemptions_per_coupon_integer" =>
                "Il doit s'agir d'un numéro valide",
            "maximum_redemptions_per_user_integer" =>
                "Il doit s'agir d'un numéro valide",
            "maximum_redemptions_per_coupon_max" =>
                "supérieur à celui spécifié",
            "maximum_redemptions_per_coupon_min" => "moins que spécifié",
            "maximum_redemptions_per_user_max" => "supérieur à celui spécifié",
            "maximum_redemptions_per_user_min" => "moins que spécifié",
            "start_at_date" => "Veuillez saisir la valeur sous forme de date",
            "start_at_before" =>
                "La date de début doit être inférieure à la date de fin",
            "expire_at_date" => "Veuillez saisir la valeur sous forme de date",
            "expire_at_after" =>
                "La date de fin doit être supérieure à la date de début",
            "filter_status" => "état du filtre",
        ],
        "show" => "Détails du coupon",
        "list" => "Retour pour tous les coupons",
        "delete" => "Numérisation de coupons",
        "delete_modal" => [
            "title" => "Voulez-vous scanner le coupon ?",
            "description" => "Le coupon sera supprimé",
        ],
        "start_at" => "date de début",
        "expire_at" => "Date d'expiration",
        "edit" => "amendement",
    ],
    "cant-delete-related-to-product" =>
        "Les données ne peuvent pas être supprimées car elles sont utilisées dans des produits",
    "permission_vendor_users" => "utiliser les magasins",
    "permission_vendor_roles" => "Stocker les rôles d'utilisateur",
    "permission_vendor_roles_create" =>
        "Ajouter des rôles d'utilisateur de magasin",
    "permission_vendor_roles_edit" =>
        "Modifier les rôles des utilisateurs du magasin",
    "permission_vendor_role_name" => "le nom",
    "permission_vendor_role_name_please" =>
        "Veuillez saisir le nom de l'autorisation",
    "permission_vendor_role_permissions" => "pouvoirs",
    "permission_vendor_role_permissions_please" =>
        "Veuillez sélectionner au moins une validité",
    "vendor_users" => "utiliser les magasins",
    "vendor_users_create" => "Ajouter un utilisateur au magasin",
    "vendor_users_edit" => "Modifier un utilisateur du magasin",
    "vendor_user_name" => "nom d'utilisateur",
    "vendor_user_email" => "E-mail de l'utilisateur",
    "vendor_user_phone" => "Mobile de l'utilisateur",
    "vendor_user_password" => "Mot de passe de l'utilisateur",
    "vendor_user_password_confirm" => "Confirmer le mot de passe utilisateur",
    "vendor_user_role" => "Rôle d'utilisateur",
    "vendor_user_vendor" => "La boutique de l'utilisateur",
    "vendor_user_unblocked" => "L'interdiction a été levée de l'utilisateur",
    "vendor_user_blocked" => "L'utilisateur a été banni",
    "warehouses" => [
        "name" => "Nom du référentiel",
        "title" => "gestion des magasins",
        "single_title" => "entrepôt",
        "manage_warehouses" => "gestion des magasins",
        "yes" => "Oui",
        "no" => "Non",
        "id" => "ID d'entrepôt",
        "name_ar" => "Le nom de l'entrepôt en arabe",
        "name_en" => "Le nom de l'entrepôt en anglais",
        "torod_warehouse_name" => "Le nom de l'entrepôt de la société de colis",
        "integration_key" => "Lien clé avec la société de colis",
        "administrator_name" =>
            "Le nom de la personne responsable de l'entrepôt",
        "administrator_phone" =>
            "Le téléphone de la personne en charge de l'entrepôt",
        "administrator_email" => "Courrier en charge de l'entrepôt",
        "map_url" => "Lien vers la carte",
        "latitude" => "Latitude",
        "longitude" => "longitude",
        "create" => "Créer un nouvel entrepôt",
        "edit" => "modification du référentiel",
        "update" => "modification du référentiel",
        "search" => "recherche",
        "all" => "tout le monde",
        "filter" => "filtration",
        "not_found" => "rien",
        "map" => "emplacement de l'entrepôt",
        "show" => "Afficher les données de l'entrepôt",
        "delete" => "supprimer",
        "reset" => "concernant",
        "delete_modal" => [
            "title" => "Vous êtes sur le point de supprimer un dépôt",
            "description" =>
                "La suppression de votre candidature supprimera toutes vos informations de notre base de données.",
        ],
        "messages" => [
            "created_successfully_title" => "Dépôt créé avec succès",
            "created_successfully_body" => "Dépôt créé avec succès",
            "created_error_title" =>
                "Erreur lors de la création du référentiel",
            "created_error_body" =>
                "Une erreur s'est produite lors de la création d'un dépôt",
            "updated_successfully_title" =>
                "Le référentiel a été modifié avec succès",
            "updated_successfully_body" =>
                "Le référentiel a été modifié avec succès",
            "updated_error_title" =>
                "Erreur lors de la modification du référentiel",
            "updated_error_body" =>
                "Une erreur s'est produite lors de la modification d'un dépôt",
            "deleted_successfully_title" =>
                "Le dépôt a été supprimé avec succès",
            "deleted_successfully_message" =>
                "Le dépôt a été supprimé avec succès",
            "deleted_error_title" =>
                "Erreur lors de la suppression d'un référentiel",
            "deleted_error_message" =>
                "Une erreur s'est produite lors de la suppression d'un dépôt",
        ],
        "validations" => [
            "name_ar_required" =>
                "Le nom de l'entrepôt en arabe est obligatoire",
            "name_ar_string" =>
                "Le type de champ Nom du référentiel arabe doit être une chaîne",
            "name_ar_min" =>
                "Le nombre minimum de lettres pour le nom de l'entrepôt en arabe est de trois lettres",
            "name_en_required" => "Le nom de l'entrepôt en anglais est requis",
            "name_en_string" =>
                "Le type de champ du nom du référentiel en anglais doit être une chaîne",
            "name_en_min" =>
                "Le nombre minimum de lettres pour le nom de l'entrepôt en anglais est de trois lettres",
            "torod_warehouse_name_string" =>
                "Le type de champ Nom de l'entrepôt de la société de colis doit être une chaîne",
            "integration_key_required" =>
                "La clé de liaison avec la société de colis est requise",
            "integration_key_unique" =>
                "La clé de la mise en relation avec une entreprise de colis existe déjà",
            "administrator_name_required" =>
                "Le nom de la personne responsable de l'entrepôt est requis",
            "administrator_phone_required" =>
                "Le téléphone de la personne en charge de l'entrepôt est requis",
            "administrator_email_required" =>
                "L'adresse e-mail du responsable de l'entrepôt est requise",
            "map_url_required" => "Lien vers la carte requis",
            "map_url_url" => "Le lien vers la carte doit être un lien Web",
            "latitude_required" =>
                "Vous devez choisir un emplacement pour l'entrepôt",
            "longitude_required" =>
                "l'emplacement de l'entrepôt doit être sélectionné",
        ],
        "additional_unit_price" => "Prix d'emballage incrémental",
        "package_covered_quantity" =>
            "L'emballage comprend un certain nombre de pièces",
        "package_price" => "Prix de l'emballage",
        "countries" => "Pays d'entrepôt",
        "empty-countries" =>
            "Il n'est pas possible d'ajouter un entrepôt car tous les pays du système ont déjà été liés à des entrepôts",
    ],
    "delivery" => [
        "title" => "Expédition",
        "delete-modal-title" => "Confirmer la suppression",
        "domestic-zones" => [
            'name' => 'Nom de la région',
            "title" => "zones de livraison",
            "show-title" => "Voir les zones de livraison",
            "create-title" => "Ajouter une zone de livraison",
            "edit-title" => "Ajuster la zone de livraison",
            "no-zones" => "Il n'y a pas de zones de livraison",
            "create" => "Ajouter une zone de livraison",
            "id" => "Numéro de zone de livraison",
            "name-ar" => "Le nom de la région est arabe",
            "name-en" => "Le nom de la région est l'anglais",
            "cities-count" => "nombre de villes",
            "delete-body" =>
                "Êtes-vous sûr de vouloir supprimer la zone de livraison : zone",
            "cities" => "Villes de la zone de livraison",
            "deliver-fees" => "Frais de livraison (SAR)",
            "delivery-type" => "Type de livraison",
            "countries" => "Des pays",
            "delivery_fees" => "Frais de livraison",
            "delivery_fees_covered_kilos" =>
                "Les frais de livraison couvrent le nombre de kilos",
            "additional_kilo_price" => "Prix du kilo supplémentaire",
            "messages" => [
                "success-title" => "opération réussie",
                "deleted" => "La zone de livraison a été supprimée avec succès",
                "created" => "La zone de livraison a été ajoutée avec succès",
                "updated" => "La zone de livraison a été modifiée avec succès",
                "warning-title" => "l'opération n'a pas pu être complété",
                "no-countries" =>
                    "Tous les pays ont été connectés à des zones de livraison avant",
                "select-country" => "Veuillez sélectionner un pays valide",
            ],
            "delivery-feeses" => [
                "title" => "Frais de livraison au poids",
                "weight-from" => "poids de",
                "weight-to" => "poids pour moi",
                "delivery-fees" => "Frais de livraison",
                "download-desc" =>
                    "Les prix peuvent être contrôlés en joignant un fichier CSV contenant le poids de, le poids à, le prix. Vous pouvez télécharger une copie du fichier, supprimer la première ligne, puis insérer vos données",
                "download-validation-desc" =>
                    "Les champs doivent contenir (le poids en kilos accepte les fractions) et (le poids en kilos accepte les fractions) et (le prix en riyals accepte les fractions)",
                "download-rows-desc" =>
                    "Seules les 500 premières lignes seront incluses, et dans le cas où il y a une ligne qui n'est pas d'accord avec les conditions, le fichier sera ignoré dans son ensemble",
                "download" => "Télécharger une copie du prix",
                "upload" => "téléchargement de fichiers",
                "delivery_fees_sheet" => "Fichier de prix",
                "sheet-uploaded" =>
                    "Le fichier de prix a été téléchargé et mis à jour dans la base de données",
            ],
        ],
    ],
    "torodCompanies" => [
        "title" => "Gestion des sociétés d'expédition de colis",
        "single_title" => "Transporteur",
        "manage_torodCompanies" => "Gestion des sociétés d'expédition de colis",
        "yes" => "Oui",
        "no" => "Non",
        "id" => "ID de l'entreprise",
        "name_ar" => "Nom de l'entreprise en arabe",
        "name_en" => "Nom de l'entreprise en anglais",
        "desc_ar" => "Description de l'entreprise en arabe",
        "desc_en" => "Description de l'entreprise en anglais",
        "active_status" => "statut de l'entreprise",
        "delivery_fees" => "Frais d'expédition",
        "domestic_zone_id" => "Identifiant de la zone de livraison",
        "domestic_zone" => "zone de livraison",
        "torod_courier_id" => "ID de l'entreprise sur les colis",
        "create" => "Créer une nouvelle société",
        "edit" => "Modification de l'entreprise",
        "update" => "Modification de l'entreprise",
        "search" => "recherche",
        "all" => "tout le monde",
        "filter" => "filtration",
        "not_found" => "rien",
        "map" => "Le site internet de l'entreprise",
        "show" => "Afficher les données de l'entreprise",
        "delete" => "supprimer",
        "active" => "actif",
        "inactive" => "pas actif",
        "choose_state" => "Sélectionnez le statut de l'entreprise",
        "choose_domistic_zone" => "Choisissez la zone de livraison",
        "logo" => "Logo d'entreprise",
        "delete_modal" => [
            "title" => "Vous êtes sur le point de supprimer une entreprise",
            "description" =>
                "La suppression de votre candidature supprimera toutes vos informations de notre base de données.",
        ],
        "messages" => [
            "created_successfully_title" => "Entreprise établie avec succès",
            "created_successfully_body" => "Entreprise établie avec succès",
            "created_error_title" => "Erreur de création de société",
            "created_error_body" =>
                "Quelque chose s'est mal passé lors de la création d'une entreprise",
            "updated_successfully_title" =>
                "La société a été modifiée avec succès",
            "updated_successfully_body" =>
                "La société a été modifiée avec succès",
            "updated_error_title" =>
                "Erreur lors de la modification de l'entreprise",
            "updated_error_body" =>
                "Une erreur s'est produite lors de la modification d'une entreprise",
            "deleted_successfully_title" =>
                "La société a été supprimée avec succès",
            "deleted_successfully_message" =>
                "La société a été supprimée avec succès",
            "deleted_error_title" =>
                "Erreur lors de la suppression d'une entreprise",
            "deleted_error_message" =>
                "Une erreur s'est produite lors de la suppression d'une entreprise",
        ],
        "validations" => [
            "name_ar_required" =>
                "Le nom de l'entreprise en arabe est obligatoire",
            "name_ar_string" =>
                "Le type de champ Nom de la société en arabe doit être une chaîne",
            "name_ar_min" =>
                "Le nombre minimum de lettres pour le nom de l'entreprise en arabe est de trois lettres",
            "name_en_required" =>
                "Le nom de l'entreprise en anglais est requis",
            "name_en_string" =>
                "Le type de champ English Company Name doit être une chaîne",
            "name_en_min" =>
                "Le nombre minimum de lettres pour le nom de l'entreprise en anglais est de trois lettres",
            "desc_ar_required" =>
                "La description de l'entreprise en arabe est obligatoire",
            "desc_ar_string" =>
                "Le type de champ de description de l'entreprise en arabe doit être une chaîne",
            "desc_ar_min" =>
                "Le nombre minimum de caractères pour le champ de description de l'entreprise en arabe est de trois lettres",
            "desc_en_required" =>
                "Une description de l'entreprise en anglais est requise",
            "desc_en_string" =>
                "Le type de champ de description de l'entreprise en anglais doit être une chaîne",
            "desc_en_min" =>
                "Le nombre minimum de caractères pour le champ Company Description en anglais est de trois caractères",
            "active_status_boolean" =>
                "L'état de l'entreprise doit être une valeur booléenne",
            "delivery_fees_required" => "Des frais d'expédition sont requis",
            "delivery_fees_numeric" => "La valeur d'expédition doit être",
            "domestic_zone_id_required" => "Zone d'expédition requise",
            "torod_courier_id_required" =>
                "L'identifiant de l'entreprise de colis est requis",
            "torod_courier_id_unique" =>
                "L'identifiant d'entreprise de Parcel existe déjà",
            "logo_image" => "Le logo téléchargé doit être un type d'image",
            "logo_mimes" =>
                "Les extensions autorisées pour le logo sont jpeg, png, jpg, gif, svg",
            "logo_max" =>
                "La taille maximale d'un logo d'entreprise est de 2048M",
        ],
    ],
    "integrations" => [
        "national-warehouse" => "Entrepôt local en Arabie Saoudite",
    ],
    "statistics" => [
        "admin" => [
            "total_customers" => "Nombre de clients",
            "total_orders" => "Le nombre de commandes",
            "total_sales" => "ventes totales",
            "total_revenues" => "Total des gains",
            "total_vendors" => "Nombre de marchands",
            "customer_rating_ratio" => "Taux d'évaluation des clients",
            "best_selling_vendors" => "marchands les plus vendus",
            "best_selling_products" => "Produits les plus vendus",
            "total_selling_categories" => "Département le plus vendu",
            "most_requested_customers" => "Clients les plus exigeants",
            "total_requests_according_to_status" =>
                "Le nombre de demandes selon chaque cas",
            "total_requests_according_to_country" =>
                "Le nombre de candidatures selon chaque pays",
            "products_count" => "produits totaux",
        ],
        "vendor" => [
            "total_orders" => "Le nombre de commandes",
            "total_sales" => "ventes totales",
            "total_revenues" => "Total des gains",
            "best_selling_products" => "Produits les plus vendus",
            "total_requests_according_to_status" =>
                "Le nombre de demandes selon chaque cas",
            "total_requests_according_to_country" =>
                "Le nombre de candidatures selon chaque pays",
        ],
        "customer" => "client",
        "order" => "demander",
        "vendors" => "marchand",
    ],
    "shipping_type" => "Type d'expédition",
    "shippingMethods" => [
        "torod" => "compagnie de colis",
        "bezz" => "Compagnie maritime commerciale",
        "integration_key" => "code de liaison",
        "choose_key" => "Choisissez le code du lien",
        "choose_type" => "Choisissez le type d'envoi",
        "create" => "Créer une compagnie maritime",
        "logo" => "photo de la compagnie maritime",
        "store" => "sauvegarder",
        "name_ar" => "Le nom est en arabe",
        "name_en" => "nom anglais",
        "type" => "Taper",
        "cod_collect_fees" => "Frais de recouvrement de salaire à domicile",
        "id" => "ID de la compagnie maritime",
        "manage_shippingMethods" => "Gestion des compagnies maritimes",
        "search" => "recherche",
        "filter" => "filtration",
        "not_found" => "Il n'y a pas de compagnies maritimes",
        "index" => "compagnies maritimes",
        ShippingMethodType::NATIONAL => "local",
        ShippingMethodType::INTERNATIONAL => "international",
        "show" => "Offre de la compagnie maritime",
        "edit" => "Modifier la compagnie maritime",
        "delete" => "Supprimer la compagnie maritime",
        "delete_modal" => [
            "title" => "Confirmer la suppression",
            "description" =>
                "Voulez-vous vraiment supprimer la compagnie maritime ?",
        ],
        "messages" => [
            "created_successfully_title" =>
                "Compagnie maritime établie avec succès",
            "created_successfully_body" =>
                "Compagnie maritime établie avec succès",
            "created_error_title" =>
                "Erreur lors de la création de la compagnie maritime",
            "created_error_body" =>
                "Quelque chose s'est mal passé lors de la création de la compagnie maritime",
            "updated_successfully_title" =>
                "La compagnie maritime a été modifiée avec succès",
            "updated_successfully_body" =>
                "La compagnie maritime a été modifiée avec succès",
            "updated_error_title" =>
                "Erreur lors de la modification de la compagnie maritime",
            "updated_error_body" =>
                "Une erreur s'est produite lors de la modification de la compagnie maritime",
            "deleted_successfully_title" =>
                "La compagnie maritime a été supprimée avec succès",
            "deleted_successfully_message" =>
                "La compagnie maritime a été supprimée avec succès",
            "deleted_error_title" =>
                "Erreur lors de la suppression de la compagnie maritime",
            "deleted_error_message" =>
                "Une erreur s'est produite lors de la suppression de l'opérateur",
            "related-domestic-zones-synced" =>
                "La compagnie maritime a été reliée avec succès aux zones de livraison",
        ],
        "related-domestic-zones" =>
            "Zones de livraison des compagnies maritimes",
    ],
    "order_statuses" => [
        OrderStatus::REGISTERD => "En cours de construction",
        OrderStatus::PAID => "payé",
        OrderStatus::SHIPPING_DONE => "Livré",
        OrderStatus::IN_DELEVERY => "La livraison est en cours",
        OrderStatus::COMPLETED => "complet",
        OrderStatus::CANCELED => "annulé",
        "refund" => "retour",
    ],
    "banks" => [
        "title" => "banques",
        "single_title" => "la Banque",
        "all_banks" => "Toutes les banques",
        "manage_banks" => "Gestion bancaire",
        "id" => "Identifiant bancaire",
        "name_ar" => "nom arabe",
        "name_en" => "Le nom est en anglais",
        "is_active" => "la condition",
        "yes" => "Oui",
        "no" => "Non",
        "create" => "Créer une nouvelle banque",
        "update" => "Ajustement bancaire",
        "search" => "recherche",
        "all" => "tout le monde",
        "filter" => "filtration",
        "not_found" => "rien",
        "show" => "Consulter les données bancaires",
        "delete" => "supprimer",
        "active" => "actif",
        "inactive" => "pas actif",
        "choose_status" => "Sélectionnez l'état de la banque",
        "filter_is_active" => "Filtrer par statut",
        "delete_modal" => [
            "title" => "Vous êtes sur le point de supprimer une banque",
            "description" =>
                "La suppression de votre candidature supprimera toutes vos informations de notre base de données.",
        ],
        "messages" => [
            "created_successfully_title" => "La banque a été créée avec succès",
            "created_successfully_body" => "La banque a été créée avec succès",
            "created_error_title" => "Erreur lors de la création de la banque",
            "created_error_body" =>
                "Une erreur s'est produite lors de la création de la banque",
            "updated_successfully_title" =>
                "La banque a été modifiée avec succès",
            "updated_successfully_body" =>
                "La banque a été modifiée avec succès",
            "updated_error_title" =>
                "Erreur lors de la modification de la banque",
            "updated_error_body" =>
                "Une erreur s'est produite lors de la modification de la banque",
            "deleted_successfully_title" =>
                "La banque a été supprimée avec succès",
            "deleted_successfully_message" =>
                "La banque a été supprimée avec succès",
            "deleted_error_title" =>
                "Erreur lors de la suppression de la banque",
            "deleted_error_message" =>
                "Une erreur s'est produite lors de la suppression de la banque",
        ],
        "validations" => [
            "name_ar_required" => "Le nom de la banque en arabe est requis",
            "name_ar_string" =>
                "Le nom de la banque arabe doit être une chaîne",
            "name_ar_min" =>
                "Le nombre minimum de lettres au nom de la Banque Arabe est d'au moins 3 lettres",
            "name_en_required" => "Le nom de la banque en anglais est requis",
            "name_en_string" =>
                "Le nom de la banque en anglais doit être une chaîne",
            "name_en_min" =>
                "Le nombre minimum de lettres dans le nom de la banque anglaise est d'au moins 3 lettres",
        ],
    ],
    "general_settings" => "réglages généraux",
    "warning" => "avertissement",
    "action-disabled" => "Cette action est actuellement désactivée",
    "is_visible" => "la condition",
    "bezz" => "Société des abeilles",
    "tracking_id" => "ID de suivi d'expédition",
    "no_shipment" => "pas encore expédié",
    "shipping_info" => "données d'expédition",
    "track_shipment" => "suivi de commande",
    "beez_id" => "Identifiant du magasin Biz",
    "beez_id_unique" => "L'identifiant Biz Store existe déjà",
    "paid" => "payé",
    "update" => "mettre à jour",
    "delete" => "supprimer",
    "shipping_type_placeholder" => "Choisissez le type de connexion",
    "shipping_countries_placeholder" => "Choisissez le pays",
    "country_assossiated_to_domestic_zone" =>
        "Le pays est déjà lié à une zone de livraison",
    "national" => "local",
    "international" => "international",
    "country" => "Pays",
    "country_placeholder" => "Choisissez le pays",
    "countries_prices" => [
        "id" => "Identifiant bancaire",
        "title" => "Prix du produit selon chaque pays",
        "country" => "Pays",
        "price" => "nom anglais",
        "price_before" => "la condition",
        "add_edit_alert" =>
            "Il sera permis de modifier ou d'ajouter le prix du produit pour chaque pays dans le cas où ce produit serait modifié",
        "list" => "Voir les prix des produits selon chaque pays",
        "delete_modal" => [
            "title" => "Vous êtes sur le point de supprimer un prix de pays",
            "description" =>
                "La suppression de votre candidature supprimera toutes vos informations de notre base de données.",
        ],
        "messages" => [
            "created_successfully_title" =>
                "Le taux d'état a été créé avec succès",
            "created_successfully_body" =>
                "Le taux d'état a été créé avec succès",
            "created_error_title" =>
                "Erreur lors de la création du prix de l'État",
            "created_error_body" =>
                "Une erreur s'est produite lors de la création du prix du pays",
            "updated_successfully_title" =>
                "Le prix de l'état a été modifié avec succès",
            "updated_successfully_body" =>
                "Le prix de l'état a été modifié avec succès",
            "updated_error_title" =>
                "Erreur lors de l'ajustement du prix du pays",
            "updated_error_body" =>
                "Une erreur s'est produite lors de l'ajustement du prix du pays",
            "deleted_successfully_title" =>
                "Le prix du pays a été supprimé avec succès",
            "deleted_successfully_message" =>
                "Le prix du pays a été supprimé avec succès",
            "deleted_error_title" =>
                "Erreur lors de la suppression du prix du pays",
            "deleted_error_message" =>
                "Une erreur s'est produite lors de la suppression du prix du pays",
        ],
        "validations" => [
            "country_id_required" => "état requis",
            "price_with_vat_required" => "Vous devez saisir le prix TTC",
            "price_before_required" =>
                "Le prix doit être saisi avant la remise",
            "price_min" => "Le prix le plus bas devrait être ",
            "price_before_offer_min" => "Le prix le plus bas devrait être ",
            "price_max" => "Le prix maximum devrait être de 1 000 00",
            "price_before_offer_max" =>
                "Le prix maximum devrait être de 1 000 00",
        ],
    ],
];
