<?php

use App\Enums\CustomerWithdrawRequestEnum;
use App\Enums\OrderStatus;
use App\Enums\ShippingMethodType;

return [
    "dashboard" => "Steuerplatine",
    "menu" => "Kontrollliste",
    "name" => "der Name",
    "name_ar" => "Der Name ist auf Arabisch",
    "name_en" => "Der Name ist auf Englisch",
    "image" => "Bild",
    "phone" => "Handy",
    "email" => "Email",
    "email_placeholder" => "Email eingeben",
    "password_placeholder" => "Geben Sie das Passwort ein",
    "forgot_password" => "Haben Sie Ihr Passwort vergessen ?",
    "forgot_password_email" => "Passwort-Wiederherstellung",
    "forgot_password_email_notes" =>
        "Sie können Ihr Passwort über den folgenden Link zurücksetzen:",
    "forgot_password_notes" =>
        "Geben Sie Ihre E-Mail-Adresse ein und die Anweisungen zum Zurücksetzen des Passworts werden an diese E-Mail-Adresse gesendet",
    "password" => "Passwort",
    "new_password" => "Passwort",
    "confirm_new_password" => "Passwort Bestätigung",
    "password_reset" => "Setzen Sie das Passwort zurück",
    "confirm_new_password_placeholder" => "Passwort bestätigen eingeben",
    "remember_me" => "Mich erinnern",
    "sign_in" => "anmelden",
    "sign" => "Eingang",
    "close" => "Schließen",
    "add" => "Hinzufügen",
    "save" => "speichern",
    "reset" => "Zurücksetzen",
    "back" => "Zurückkehren",
    "create" => "Konstruktion",
    "edit" => "Änderung",
    "send" => "schicken",
    "desc_order" => "absteigend",
    "asc_order" => "Progressiv",
    "not_found" => "nicht verfügbar",
    "order_placed" => "Die Uhrzeit, zu der die Anfrage gesendet wurde",
    "an_order_has_been_placed" => "Die Anfrage wurde vom Client gesendet",
    "admin" => "Administrator",
    "price" => "der Preis",
    "errors" => "falsche Daten",
    "remember_login" => "Haben Sie sich an Ihre Daten erinnert?",
    "actions" => "Verfahren",
    "yes" => "Ja",
    "no" => "NEIN",
    "quantity" => "Menge",
    "last_update" => "Letzte Aktualisierung",
    "payment_data" => "Zahlungsdaten",
    "address_data" => "Standort- und Adressdaten",
    "created_at" => "Datum erstellt",
    "Showing" => "Rezension",
    "to" => "Zu",
    "of" => "aus",
    "from" => "aus",
    "results" => "Ergebnisse",
    "select" => "Wählen",
    "welcome" => "Hallo",
    "notifications" => [
        "unread" => "Ungelesene Benachrichtigungen",
        "notifications" => "Hinweise",
        "vendor" => [
            "modify" => [
                "title" => "Daten speichern",
                "message" => "Geschäftsdaten wurden vom Management geändert",
            ],
            "warning" => [
                "title" => "Warnung vom Management",
            ],
            "product" => [
                "approve" => [
                    "title" => "Produkt zugelassen:",
                    "message" =>
                        "Produktänderungen werden vom Management genehmigt",
                ],
                "reject" => [
                    "title" => "Produkt abgelehnt:",
                    "message" =>
                        "Änderungen am Produkt wurden vom Management abgelehnt",
                ],
                "modify" => [
                    "title" => "Bearbeiten Sie ein Produkt:",
                    "message" => "Das Produkt wurde vom Management modifiziert",
                ],
            ],
            "order" => [
                "created" => [
                    "title" => "neue Anfrage",
                    "message" =>
                        "Eine neue Anfrage wurde erstellt mit dem Code: #",
                ],
            ],
            "admin" => [
                "transaction" => [
                    "created" => [
                        "title" => "neue Anfrage",
                        "message" =>
                            "Eine neue Anfrage wurde erstellt mit dem Code: #",
                    ],
                ],
            ],
        ],
    ],
    "vendor_website" => "Webseite",
    "vendors" => "Geschäfte",
    "vendors_list" => "Alle Geschäfte",
    "vendors_show" => "Ladenansicht",
    "vendors_edit" => "Änderung speichern",
    "vendor_logo" => "Shop-Logo",
    "vendor_owner_name" => "Name des Ladenbesitzers",
    "vendor_name" => "Geschäftsname",
    "vendor_phone" => "Handy",
    "vendor_second_phone" => "zusätzliches Handy",
    "vendor_tax_number" => "Steuernummer",
    "vendor_tax_certificate" => "Mehrwertsteuerbescheinigung",
    "vendor_iban_certificate" => "IBAN-Zertifikat",
    "vendor_commercial_register" => "Handelsregister",
    "vendor_commercial_register_date" => "Das Ablaufdatum der Gewerbeanmeldung",
    "vendor_bank" => "Bank Name",
    "vendor_bank_number" => "Kontonummer",
    "vendor_broc" => "Markeneigentumsbescheinigung",
    "vendor_iban" => "IBAN-Nummer",
    "vendor_email" => "E-Mail speichern",
    "vendor_password" => "Passwort",
    "vendor_password_confirm" => "Passwort Bestätigung",
    "vendor_address" => "die Adresse",
    "vendor_admin_percentage" => "Verwaltungsprozentsatz",
    "vendor_admin_percentage_order" => "Ranking nach Managementprozentsatz",
    "vendor_admin_percentage_hint" =>
        "Geben Sie den Verwaltungsprozentsatz der Verkäufe des Verkäufers an",
    "vendor_wallet" => "Portfolio",
    "vendor_products" => "Kundenprodukte",
    "vendor_rate" => "Auswertung",
    "vendor_sales" => "die Verkäufe",
    "vendor_description" => "Beschreibung speichern",
    "vendor_external_warehouse" => "externe Lager",
    "vendor_status" => "Shop-Status",
    "vendor_registration_date" => "Datum der Registrierung",
    "vendor_active" => "Ermöglicht",
    "vendor_inactive" => "Nicht aktiviert",
    "vendor_pending" => "Shop-Genehmigung steht noch aus",
    "vendor_approved" => "Der Shop wurde genehmigt",
    "vendor_not_approved" => "Laden abgelehnt",
    "vendor_warnings" => "Warnungen speichern",
    "vendor_warning" => "Die Warnung",
    "vendor_warning_new" => "Neue Warnung",
    "vendor_warning_new_add" => "Fügen Sie eine neue Warnung hinzu",
    "vendor_warning_date" => "Warnungsdatum",
    "vendor_warning_send" =>
        "Eine Warnung wurde erfolgreich an den Shop gesendet",
    "vendor_active_on" => "Der Shop ist aktiviert",
    "vendor_active_off" => "Laden ist deaktiviert",
    "vendor_commission" =>
        "Verwaltungsprozentsatz des Verkaufspreises (%) (Kauf von der Plattform)",
    "vendor_is_international" =>
        "Ermöglichen Sie dem Geschäft, international zu handeln",
    "transactions" => "Anfragen",
    "transaction_edit" => "Änderung",
    "transactions_list" => "Alle Anfragen",
    "delivery_fees" => "Versandkosten",
    "city" => "Stadt",
    "payment_method" => "Bezahlverfahren",
    "total" => "Der Gesamtbetrag",
    "total_sub" => "Der gezahlte Betrag",
    "paid_amount" => "Der gezahlte Betrag",
    "coupon-discount" => "Rabattbetrag",
    "vendors_count" => "Anzahl der Verkäufer",
    "shipping" => "Versand",
    "all" => "alle",
    "registered" => "Eingetragen",
    "shipping_done" => "es wird aufgeladen",
    "in_delivery" => "Es ist verbunden",
    "completed" => "vollendet",
    "canceled" => "Abgesagt",
    "refund" => "Rückblick",
    "transaction_show" => "Beobachten Sie die Anfrage",
    "transaction_main_details" => "Stammdaten der Bestellung",
    "transaction_id" => "Anfrage Code",
    "transaction_date" => "Das Datum der Bewerbung",
    "transaction_status" => "Bestellstatus",
    "transaction_note" => "Hinweise zur Bestellung",
    "transaction_customer_filter_placeholder" =>
        "Suche nach Kundennummer oder Name",
    "transaction_id_filter_placeholder" => "Suche nach Anfragecode",
    "transaction_not_has_ship" =>
        "Die Bestellung hat keine Sendungsverfolgungsnummer, was bedeutet, dass sie nicht an das Versandunternehmen gesendet wurde",
    "transaction_status_not_high" =>
        "Der Bewerbungsstatus kann nicht in einen früheren umgewandelt werden",
    "transaction_vendor_product" => "Shop-Produkte (:Vendor)",
    'transaction_gateway_id' => 'Gateway transaction id',
    "transaction_invoice" => [
        "app_name" => "Das Nationale Zentrum für Palmen und Datteln",
        "title" => "die Nachfrage",
        "header_title" => "Bestellanfrage",
        "invoice_brif" => "Bestellübersicht",
        "address" => "die Adresse",
        "zip_code" => "Postleitzahl",
        "legal_registration_no" => "Gesetzliche Registrierungsnummer",
        "client_name" => "Der Empfänger",
        "client_sale" => "der Käufer",
        "email" => "Email",
        "bill_info" => "Käuferdaten",
        "ship_info" => "Empfängerdaten",
        "website" => "der Standort",
        "contact_no" => "Kontakt Nummer",
        "invoice_no" => "Bestellnummer",
        "date" => "Das Datum der Bewerbung",
        "payment_status" => "Erstattungsstatus",
        "total_amount" => "Gesamtbestellung",
        "shipping_address" => "Lieferanschrift",
        "phone" => "Handy",
        "sub_total" => "Subpreis",
        "estimated_tax" => "Steuer",
        "tax_no" => "Steuernummer",
        "discount" => "Rabatt",
        "shipping_charge" => "Versandgebühr",
        "download" => "Anfrage herunterladen",
        "print" => "Drucken Sie die Anfrage aus",
        "not_found" => "Es gibt keine Produkte für diese Bestellung",
        "shipment_no" => "Liefernummer",
        "payment_type" => "Bezahlverfahren",
        "sub_from_wallet" => "vom Portemonnaie abgezogen",
        "sub_total_without_vat" => "Der Gesamtbetrag enthält keine Steuern",
        "vat_percentage" => "Steuersatz",
        "vat_rate" => "Steuerwert",
        "products_table_header" => [
            "product_details" => "das Produkt",
            "rate" => "Einzelpreis",
            "quantity" => "Menge",
            "amount" => "Der Gesamtbetrag enthält keine Steuern",
            "tax_ratio" => "Steuersatz",
            "tax_value" => "Steuerwert",
            "barcode" => "Barcode",
            "total_with_tax" => "Der Gesamtbetrag ist inklusive Steuern",
        ],
    ],
    "customers_list" => "Kunden",
    "customer_details" => "Kundendaten",
    "customer_name" => "Kundenname",
    "customer_phone" => "Handynummer des Kunden",
    "customer_email" => "E-Mail des Kunden",
    "customer_avatar" => "Kundenfoto",
    "customer_addresses_count" => "Anzahl der Adressen",
    "customer_transactions_count" => "Die Anzahl der Bestellungen",
    "customer_warnings_count" => "Die Anzahl der Berichte",
    "customer_priority" => "Kundenbedeutung",
    "customer_banned" => "Client-Verbot",
    "customer_last_login" => "letzter Eintrag",
    "customer_last_activity" => "Letzte Aktivität",
    "customer_change_priority_message" =>
        "Kundenwichtigkeit wurde erfolgreich geändert",
    "customer_perfect" => "Ideal",
    "customer_important" => "Wichtig",
    "customer_show" => "Kundendaten",
    "customer_edit" => "Kundendaten ändern",
    "customer_regular" => "normal",
    "customer_parasite" => "Parasitär",
    "customer_caution" => "Passe darauf auf",
    "customer_noDeal" => "Nicht damit umgehen",
    "customer_unblocked" => "Die Sperre wurde vom Kunden aufgehoben",
    "customer_blocked" => "Der Client wurde gesperrt",
    "customer_new_password" =>
        "(lassen Sie es leer, wenn Sie es nicht geändert haben) Passwort",
    "customer_confirm_new_password" => "Passwort Bestätigung",
    "customer_registration_date" => "Datum der Registrierung",
    "customer_addresses" => "Kundenadressen",
    "price_before_offer" => "Preis vor Gebot",
    "address_description" => "Titel Beschreibung",
    "edits_history" => "Änderungsprotokoll",
    "address_type" => "Adresstyp",
    "address_id" => "Adress-ID-Nummer",
    "desc_en" => "Beschreibung auf Englisch",
    "desc_ar" => "Beschreibung auf Arabisch",
    "category_id" => "Hauptteil",
    "sub_category_id" => "Erster Unterabschnitt",
    "final_category_id" => "letzter Unterabschnitt",
    "type_id" => "Klasse",
    "order" => "Anordnung",
    "width" => "das Angebot",
    "height" => "Höhe",
    "length" => "Höhe",
    "total_weight" => "das Gesamtgewicht",
    "net_weight" => "Reingewicht",
    "quantity_bill_count" => "Die Nummer der Menge",
    "bill_weight" => "Die Nummer der Menge",
    "customer_finances" => [
        "title" => "Kundenfinanzen",
        "payment_methods" => [
            "cash" => "Kasse",
            "visa" => "Visa",
            "wallet" => "Portfolio",
        ],
        "wallets" => [
            "all_wallets" => "Alles konservativ",
            "id" => "Brieftaschen-ID",
            "create" => "Erstellen Sie eine neue Brieftasche",
            "edit" => "Ändern Sie das Portfolio des Kunden",
            "manage" => "Verwaltung des Kundenportfolios",
            "delete" => "Löschen Sie die Brieftasche",
            "import" => "Brieftaschen importieren",
            "search" => "Suche in Portfolios",
            "title" => "Portfolios zur Kundenzufriedenheit",
            "single_title" => "Kundengeldbörse",
            "customer_name" => "Kundenname",
            "attachments" => "Anhänge",
            "no_attachments" => "Es gibt keine Anhänge",
            "by_admin" => "von",
            "is_active" => "Aktivierungsstatus",
            "last_update" => "Letzte Aktualisierung",
            "active" => "aktiv",
            "inactive" => "nicht aktiv",
            "choose_state" => "Brieftaschenstatus auswählen",
            "choose_customer" => "Wählen Sie einen Kunden aus",
            "amount" => "Gleichgewicht",
            "reason" => "der Grund",
            "created_at" => "Das Datum, an dem die Brieftasche erstellt wurde",
            "created_at_select" => "Wählen Sie ein Datum aus",
            "all" => "alle",
            "filter" => "filtern",
            "no_result_found" => "keine Ergebnisse gefunden",
            "attachment" => "Anhänge",
            "has_attachment" => "Anhangsvorschau",
            "has_no_attachment" => "Es gibt keine Anhänge",
            "change_status" => "Wallet-Status ändern",
            "manage_wallet_balance" => "Wallet-Guthabenverwaltung",
            "current_wallet_balance" => "aktuellen Wallet-Guthaben",
            "wallet_balance" => "Wallet-Guthaben",
            "wallets_transactions" => [
                "title" => "Portfoliotransaktionen",
                "single_title" => "Wallet-Transaktion",
                "customer_name" => "Kundenname",
                "wallet_id" => "Brieftaschen-ID",
                "type" => "Art der Transaktion",
                "amount" => "Der Betrag der Transaktion",
                "transaction_date" => "Transaktionsdatum",
            ],
            "validations" => [
                "customer_id_required" => "Kundenfeld ist erforderlich",
                "customer_id_unique" =>
                    "Es ist nicht möglich, mehr als ein Wallet für einen Kunden zu erstellen",
            ],
            "messages" => [
                "created_successfully_title" => "Neues Kundenportfolio",
                "created_successfully_body" =>
                    "Ein neues Kundenportfolio wurde erfolgreich aufgebaut",
                "created_error_title" =>
                    "Client-Wallet-Erstellung fehlgeschlagen",
                "created_error_body" =>
                    "Das Erstellen einer neuen Client-Wallet ist fehlgeschlagen",
                "updated_successfully_title" =>
                    "Ändern Sie den Status eines Kundenportfolios",
                "updated_successfully_body" =>
                    "Der Status der Brieftasche eines Kunden wurde erfolgreich geändert",
                "updated_error_title" =>
                    "Fehler beim Ändern des Status der Brieftasche eines Kunden",
                "updated_error_body" =>
                    "Der Vorgang zum Ändern des Status der Brieftasche eines Clients ist fehlgeschlagen",
                "customer_has_wallet_title" =>
                    "Für diesen Kunden kann kein Wallet erstellt werden",
                "customer_has_wallet_message" =>
                    "Es ist nicht möglich, für diesen Kunden eine Brieftasche zu erstellen, da er bereits eine besitzt",
            ],
            "customer_info" => [
                "email" => "Post",
                "phone" => "Handy",
            ],
            "transaction" => [
                "title" => "Wallet-Guthabenverwaltung",
                "wallet_transactions_log" => "Wallet-Transaktionsverlauf",
                "id" => "Transaktions-ID",
                "type" => "Art der Transaktion",
                "choose_type" => "Wählen Sie die Art der Transaktion",
                "amount" => "Transaktionswert",
                "date" => "Transaktionsdatum",
                "add" => "Fügen Sie + hinzu",
                "sub" => "Rivale -",
                "success_add_title" =>
                    "Erfolgreicher Prozess zum Hinzufügen von Krediten",
                "success_add_message" =>
                    "Die Karte des Kunden wurde erfolgreich belastet",
                "success_sub_title" => "Erfolgreicher Kreditabzug",
                "success_sub_message" =>
                    "Das Kartenguthaben des Kunden wurde erfolgreich belastet",
                "fail_add_title" => "Guthaben hinzufügen fehlgeschlagen",
                "fail_add_message" =>
                    "Kreditkartenkreditvorgang fehlgeschlagen",
                "fail_sub_title" => "Guthabenabzug fehlgeschlagen",
                "fail_sub_message" =>
                    "Die Belastung der Karte des Kunden ist fehlgeschlagen",
                "cannot_subtract_message" =>
                    "Das Kartenguthaben ist kleiner als die Rabattwerte",
                "user_id" => "Der Prozess wurde von durchgeführt",
                "transaction_type" => [
                    "title" => "Operationstyp",
                    "choose_transaction_type" =>
                        "Wählen Sie die Art der Operation",
                    "purchase" => "Produkte kaufen",
                    "gift" => "Geschenk",
                    "bank_transfer" => "Banküberweisung",
                    "compensation" => "Entschädigung",
                    "sales_balance" => "Verkaufsbilanz",
                ],
                "opening_balance" => "Anfangsbestand",
                "validations" => [
                    "amount_required" =>
                        "Das Transaktionswertfeld ist erforderlich",
                    "amount_numeric" =>
                        "Der Transaktionswert muss ein numerischer Wert sein",
                    "type_required" =>
                        "Das Feld Transaktionstyp ist erforderlich",
                    "type_numeric" =>
                        "Sie müssen die Art der Transaktion auswählen",
                    "transaction_type_required" =>
                        "Das Feld Vorgangstyp ist erforderlich",
                    "transaction_type_numeric" =>
                        "Die Betriebsart muss ausgewählt werden",
                ],
                "save" => "Speichern Sie den Vorgang",
            ],
        ],
    ],
    "customer-cash-withdraw" => [
        "page-title" => "Abhebungsanfragen von Kundenguthaben",
        "show-page-title" => "Aufforderung, das Guthaben des Kunden abzuheben",
        "status" => "Bestellstatus",
        "approved" => "akzeptabel",
        "not-approved" => "inakzeptabel",
        "customer-name-search" => "Suche nach Kundenname oder Handynummer",
        "customer-name" => "Kundenname",
        "customer-phone" => "Kunde mobil",
        "customer-balance" => "Kontostand des Kunden",
        "request-id" => "Bestellnummer",
        "request-amount" => "Bestellbetrag",
        "request-bank-name" => "Der Name der Bank, an die es überwiesen wird",
        "admin-approved" => "Genehmigt worden",
        "admin-not-approved" => "Zugriff abgelehnt",
        "all-status" => "alle Fälle",
        "statuses" => [
            CustomerWithdrawRequestEnum::PENDING => "Der Eingang der Anfrage",
            CustomerWithdrawRequestEnum::APPROVED =>
                "Die Anfrage wurde ausgeführt",
            CustomerWithdrawRequestEnum::NOT_APPROVED =>
                "Anfragen wurden abgelehnt",
        ],
        "request-bank-account-name" => "Der Name des Kontoinhabers",
        "request-bank-account-iban" =>
            "Die IBAN-Nummer, auf die es übertragen wird",
        "reject-reason" => "der Ablehnungsgrund",
        "rejected-by" => "Zurückgewiesen von",
        "save-status" => "Ändern Sie den Status der Anforderung",
        "bank-receipt" => "Überweisungsbeleg anbei",
        "validations" => [
            "status-required" =>
                "Der Status der Übertragungsanfrage ist erforderlich",
            "status-in" =>
                "Der Status der Übertragungsanfrage muss (Ausgeführt, Abgelehnt oder Empfangen) sein.",
            "reject_reason-required_if" => "Ablehnungsgrund erforderlich",
            "bank_receipt-required_if" =>
                "Die Anlage des Überweisungsbelegs ist erforderlich",
            "bank_receipt-image" =>
                "Die Anlage des Überweisungsbelegs muss eine Kopie sein",
            "bank_receipt-max" =>
                "Die maximale Größe des Anhangs des Überweisungsbelegs beträgt 2 MB",
            "transaction_type-required_if" =>
                "Die Art der erforderlichen Operation",
            "transaction_type-in" =>
                "Der Vorgangstyp muss einer der verfügbaren Typen sein",
        ],
        "messages" => [
            "status-not-pending" =>
                "Diese Anforderung kann ihren Status nicht ändern, da sie bereits geändert wurde",
            "status-set-to-not-approved" =>
                "Der Status der abgelehnten Anfrage wurde erfolgreich geändert",
            "status-set-to-approved" =>
                "Der Status der Anfrage wurde erfolgreich geändert",
        ],
        "manage_wallet_balance" => "Verwaltung des Kundenportfolios",
    ],
    "categories" => [
        "title_main" => "Kategorien und Abschnitte",
        "title" => "Abschnitte",
        "single_title" => "Abschnitt",
        "all_categories" => "Alle Abschnitte",
        "choose_search_lang" => "Wählen Sie die Namenssprache",
        "manage_categories" => "Abteilungsleitung",
        "id" => "Abteilungs-ID",
        "name_ar" => "Arabischer Name",
        "name_en" => "Der Name ist auf Englisch",
        "slug_ar" => "Abschnittslink auf Arabisch",
        "slug_en" => "Abschnittslink in Englisch",
        "level" => "die Ebene",
        "parent_id" => "Folgen Sie dem Abschnitt",
        "child_id" => "gehören zu einem Unterabschnitt",
        "is_active" => "die Bedingung",
        "active" => "aktiv",
        "inactive" => "Inaktiv",
        "edit_child" => "Unterabschnitt bearbeiten",
        "edit_sub_child" => "Ändern Sie den letzten Unterabschnitt",
        "order" => "Rangfolge",
        "yes" => "Ja",
        "no" => "NEIN",
        "create" => "Erstellen Sie einen neuen Abschnitt",
        "update" => "Ändern Sie einen Abschnitt",
        "search" => "Forschung",
        "all" => "alle",
        "filter" => "filtern",
        "created_at_select" => "Wählen Sie ein Datum aus",
        "parent_name_ar" => "Der Name der Hauptabteilung auf Arabisch",
        "parent_name_en" => "Der Name der Hauptabteilung auf Englisch",
        "not_found" => "Nichts",
        "parent" => "die wichtigsten",
        "child" => "sub",
        "subchild" => "Finale",
        "child_count" => "Die Anzahl der Unterabschnitte",
        "show" => "Abschnittsdaten anzeigen",
        "delete" => "löschen",
        "arabic_date" => "Arabische Daten",
        "english_date" => "Daten in Englisch",
        "choose_category" => "Wählen Sie eine Abteilung",
        "choose_sub_category" => "Wählen Sie einen Unterabschnitt aus",
        "choose_level" => "Wählen Sie die Abteilungsebene aus",
        "image_for_show" => "Schnittbild",
        "image" => "Wählen Sie das Schnittbild aus",
        "image_title" => "Ziehen Sie das Schnittbild hierher",
        "delete_modal" => [
            "title" => "Sind Sie dabei, einen Abschnitt zu löschen?",
            "description" =>
                "Durch das Löschen Ihrer Bewerbung werden alle Ihre Informationen aus unserer Datenbank entfernt.",
        ],
        "messages" => [
            "created_successfully_title" =>
                "Der Abschnitt wurde erfolgreich erstellt",
            "created_successfully_body" =>
                "Der Abschnitt wurde erfolgreich erstellt",
            "created_error_title" => "Fehler beim Erstellen der Partition",
            "created_error_body" =>
                "Beim Erstellen der Partition ist ein Fehler aufgetreten",
            "updated_successfully_title" =>
                "Der Abschnitt wurde erfolgreich geändert",
            "updated_successfully_body" =>
                "Der Abschnitt wurde erfolgreich geändert",
            "updated_error_title" => "Fehler beim Ändern der Partition",
            "updated_error_body" =>
                "Beim Ändern der Partition ist ein Fehler aufgetreten",
            "deleted_successfully_title" =>
                "Der Abschnitt wurde erfolgreich gelöscht",
            "deleted_successfully_message" =>
                "Der Abschnitt wurde erfolgreich gelöscht",
            "deleted_error_title" => "Fehler beim Löschen der Partition",
            "deleted_error_message" =>
                "Beim Löschen der Partition ist etwas schief gelaufen",
        ],
        "validations" => [
            "name_ar_required" => "Abteilungsname in Arabisch ist erforderlich",
            "name_ar_string" =>
                "Der Name des arabischen Abschnitts muss eine Zeichenfolge sein",
            "name_ar_min" =>
                "Die Mindestbuchstabenzahl für den arabischen Abteilungsnamen beträgt mindestens 3 Buchstaben",
            "name_en_required" => "Abteilungsname in Englisch ist erforderlich",
            "name_en_string" =>
                "Der englische Abschnittsname muss eine Zeichenfolge sein",
            "name_en_min" =>
                "Die Mindestanzahl von Buchstaben im Namen der englischen Abteilung beträgt mindestens 3 Buchstaben",
            "slug_ar_required" =>
                "Abschnittslink auf Arabisch ist erforderlich",
            "slug_ar_string" =>
                "Der Link für den arabischen Abschnitt muss eine Zeichenfolge sein",
            "slug_ar_min" =>
                "Die Mindestzeichenzahl für den arabischen Abschnittslink beträgt mindestens 3 Buchstaben",
            "slug_en_required" => "Abschnittslink in Englisch ist erforderlich",
            "slug_en_string" =>
                "Abschnitts-URL muss in Form einer Textzeichenfolge vorliegen",
            "slug_en_min" =>
                "Die Mindestzeichenzahl für den Abschnittslink in Englisch beträgt mindestens 3 Zeichen",
            "level_numeric" =>
                "Die Partitionsebene muss vom numerischen Typ sein",
            "level_between" =>
                "Die Abschnittsebene sollte (Main - Sub - Sub - Final) sein.",
            "parent_id_numeric" =>
                "Die Partitions-ID mit dem höchsten numerischen Wert",
            "parent_id_exists" => "Abschnitt nicht gefunden",
            "is_featured_boolean" =>
                "Der Wert dieses Feldes muss numerisch sein",
            "is_active_boolean" => "Der Wert dieses Feldes muss numerisch sein",
            "order_unique" =>
                "Abschnittsreihenfolge kann nicht wiederholt werden",
            "image_required" => "Das Feld Abschnittsbild ist erforderlich",
            "image_image" => "Die Datei muss vom Bildtyp sein",
            "image_mimes" =>
                "Akzeptierte Erweiterungen: jpeg, png, jpg, gif, svg",
            "image_max" => "Die maximale Bildgröße beträgt 2048 KB",
        ],
    ],
    "productClasses" => [
        "name"=>"Der Name",
        "title" => "Kategorien",
        "single_title" => "Klasse",
        "all_productClasses" => "Alle Kategorien",
        "manage_productClasses" => "Kategorienverwaltung",
        "id" => "Kategorie ID",
        "name_ar" => "Arabischer Name",
        "name_en" => "Der Name ist auf Englisch",
        "yes" => "Ja",
        "no" => "NEIN",
        "create" => "Erstellen Sie eine neue Kategorie",
        "update" => "Klassenänderung",
        "search" => "Forschung",
        "all" => "alle",
        "filter" => "filtern",
        "created_at_select" => "Wählen Sie ein Datum aus",
        "not_found" => "Nichts",
        "show" => "Kategoriedaten anzeigen",
        "delete" => "löschen",
        "delete_modal" => [
            "title" => "Möchten Sie eine Kategorie löschen?",
            "description" =>
                "Durch das Löschen Ihrer Bewerbung werden alle Ihre Informationen aus unserer Datenbank entfernt.",
        ],
        "messages" => [
            "created_successfully_title" => "Kategorie erfolgreich erstellt",
            "created_successfully_body" => "Kategorie erfolgreich erstellt",
            "created_error_title" => "Fehler beim Erstellen der Klasse",
            "created_error_body" =>
                "Beim Erstellen der Kategorie ist ein Fehler aufgetreten",
            "updated_successfully_title" =>
                "Die Kategorie wurde erfolgreich geändert",
            "updated_successfully_body" =>
                "Die Kategorie wurde erfolgreich geändert",
            "updated_error_title" => "Fehler beim Ändern der Klasse",
            "updated_error_body" =>
                "Beim Ändern der Kategorie ist ein Fehler aufgetreten",
            "deleted_successfully_title" =>
                "Die Kategorie wurde erfolgreich gelöscht",
            "deleted_successfully_message" =>
                "Die Kategorie wurde erfolgreich gelöscht",
            "deleted_error_title" => "Fehler beim Löschen der Kategorie",
            "deleted_error_message" =>
                "Beim Löschen der Kategorie ist ein Fehler aufgetreten",
        ],
        "validations" => [
            "name_ar_required" => "Kategoriename auf Arabisch ist erforderlich",
            "name_ar_string" =>
                "Der arabische Klassenname muss vom Typ String sein",
            "name_ar_min" =>
                "Die Mindestanzahl von Buchstaben für den arabischen Kategorienamen beträgt mindestens 3 Buchstaben",
            "name_en_required" => "Kategoriename in Englisch ist erforderlich",
            "name_en_string" =>
                "Der englische Klassenname muss vom Typ String sein",
            "name_en_min" =>
                "Die Mindestanzahl von Buchstaben im englischen Kategorienamen beträgt mindestens 3 Buchstaben",
        ],
    ],
    "products" => [
        "title" => "Produkte",
        "single_title" => "das Produkt",
        "all_products" => "Alle Produkte",
        "manage_products" => "Produkt Management",
        "in_review_products" => "Produkte in Überprüfung",
        "id" => "Produkt ID",
        "name_ar" => "Arabischer Name",
        "name_en" => "Der Name ist auf Englisch",
        "follow_edits" => "Verfolgen Sie Änderungen",
        "desc_ar" => "Produktbeschreibung auf Arabisch",
        "desc_en" => "Produktbeschreibung in Englisch",
        "is_featured" => "Vorgestelltes Produkt",
        "is_active" => "die Bedingung",
        "active" => "aktiv",
        "inactive" => "Inaktiv",
        "price" => "der Preis",
        "unitPrice" => "Einzelpreis",
        "total" => "Der Gesamtpreis des Produkts",
        "order" => "Rangfolge",
        "category" => "Abschnitt",
        "vendor" => "das Geschäft",
        "pending" => "mein Nachbar",
        "in_review" => "unter Auswertung",
        "holded" => "hängend",
        "yes" => "Ja",
        "no" => "NEIN",
        "create" => "Erstellen Sie ein neues Produkt",
        "update" => "Ändern Sie ein Produkt",
        "search" => "Forschung",
        "all" => "alle",
        "filter" => "filtern",
        "created_at_select" => "Wählen Sie ein Datum aus",
        "not_found" => "Nichts",
        "show" => "ein Angebot",
        "delete" => "löschen",
        "edit" => "Änderung",
        "vendor_id" => "das Geschäft",
        "arabic_date" => "Arabische Daten",
        "english_date" => "Daten in Englisch",
        "choose_category" => "Wählen Sie eine Abteilung",
        "image" => "Wählen Sie das Produktbild aus",
        "image_title" => "Ziehen Sie das Produktbild hierher",
        "accepting" => "Produktannahme",
        "re-pending" => "Wählen Sie das Produkt als laufendes Produkt aus",
        "field_changed" => "Änderungen vorgenommen",
        "images" => "Produktbilder",
        "reject" => "Änderungen ablehnen",
        "write_your_reject_reason" => "Schreiben Sie den Ablehnungsgrund auf",
        "reject_reason" => "Änderungen ablehnen",
        "reject_confirm" => "Ablehnung bestätigen",
        "accept_update" => "Akzeptieren Sie Änderungen",
        "updated_products" => "Aktualisierte Produkte",
        "pending_products" => "Produkte ausstehend",
        "delete_modal" => [
            "title" => "Sind Sie dabei, ein Produkt zu löschen?",
            "description" =>
                "Durch das Löschen Ihrer Bestellung werden alle Informationen für dieses Produkt entfernt.",
        ],
        "messages" => [
            "created_successfully_title" => "Produkt erfolgreich erstellt",
            "created_successfully_body" => "Produkt erfolgreich erstellt",
            "created_error_title" => "Fehler beim Erstellen des Produkts",
            "created_error_body" =>
                "Beim Erstellen des Produkts ist ein Fehler aufgetreten",
            "updated_successfully_title" =>
                "Das Produkt wurde erfolgreich geändert",
            "updated_successfully_body" =>
                "Das Produkt wurde erfolgreich geändert",
            "updated_error_title" => "Fehler beim Ändern des Produkts",
            "updated_error_body" =>
                "Beim Ändern des Produkts ist ein Fehler aufgetreten",
            "deleted_successfully_title" =>
                "Das Produkt wurde erfolgreich gelöscht",
            "deleted_successfully_message" =>
                "Das Produkt wurde erfolgreich gelöscht",
            "deleted_error_title" => "Fehler beim Löschen des Produkts",
            "deleted_error_message" =>
                "Beim Löschen des Produkts ist ein Fehler aufgetreten",
            "status_changed_successfully_title" =>
                "Der Produktstatus wurde erfolgreich geändert",
            "status_approved_successfully_title" =>
                "Das Produkt wurde erfolgreich akzeptiert",
        ],
        "print-barcode" => "Barcode-Druck",
        "barcode" => "Barcode",
        "image-validation" =>
            "Die Mindestbreite des Bildes muss 800 Pixel und die Mindesthöhe des Bildes 800 Pixel betragen",
        "image-validation-width" =>
            "Die Mindestbreite des Bildes muss 800 Pixel betragen",
        "image-validation-height" =>
            "Die Mindestbildlänge muss 800 Pixel betragen",
        "image-validation-max" => "Bilder müssen kleiner als 1500 KB sein",
        "product_details" => "Produktdetails",
        "product_price" => "Produktpreis",
        "product_quantity" => "Menge",
        "product_reviews" => "Bewertungen",
        "product_price_final" => "Der Endpreis beinhaltet die Mehrwertsteuer",
        "prices" => [
            "countries" => "Produktpreis je nach Land",
        ],
    ],
    "countries_and_cities_title" => "Staaten und Städte",
    "coupons_title" => "Gutscheine",
    "countries" => [
        "name"=>"Der Name",
        "title" => "Länder",
        "single_title" => "Land",
        "all_countries" => "Alle Länder",
        "manage_countries" => "Staatenverwaltung",
        "id" => "Länder-ID",
        "name_ar" => "Arabischer Name",
        "name_en" => "Der Name ist auf Englisch",
        "is_active" => "die Bedingung",
        "yes" => "Ja",
        "no" => "NEIN",
        "create" => "Erstellen Sie einen neuen Zustand",
        "update" => "Zustandsänderung",
        "search" => "Forschung",
        "all" => "alle",
        "filter" => "filtern",
        "not_found" => "Nichts",
        "show" => "Länderdaten anzeigen",
        "delete" => "löschen",
        "active" => "aktiv",
        "inactive" => "nicht aktiv",
        "filter_is_active" => "Nach Status filtern",
        "code" => "Code",
        "choose_state" => "Wählen Sie das Bundesland aus",
        "country_areas" => "Regionen des Staates",
        "area_id" => "Regions-ID",
        "area_name" => "Bereichsname",
        "national" => "lokal",
        "not_national" => "nicht-lokal",
        "is_national" => "Ist das Land lokal?",
        "delete_modal" => [
            "title" => "Sind Sie dabei, ein Land zu löschen?",
            "description" =>
                "Durch das Löschen Ihrer Bewerbung werden alle Ihre Informationen aus unserer Datenbank entfernt.",
        ],
        "messages" => [
            "created_successfully_title" =>
                "Der Status wurde erfolgreich erstellt",
            "created_successfully_body" =>
                "Der Status wurde erfolgreich erstellt",
            "created_error_title" => "Fehler beim Erstellen des Status",
            "created_error_body" =>
                "Beim Erstellen des Status ist etwas schief gelaufen",
            "updated_successfully_title" =>
                "Der Status wurde erfolgreich geändert",
            "updated_successfully_body" =>
                "Der Status wurde erfolgreich geändert",
            "updated_error_title" => "Fehler beim Ändern des Status",
            "updated_error_body" =>
                "Beim Ändern des Landes ist ein Fehler aufgetreten",
            "deleted_successfully_title" =>
                "Das Land wurde erfolgreich gelöscht",
            "deleted_successfully_message" =>
                "Das Land wurde erfolgreich gelöscht",
            "deleted_error_title" => "Fehler beim Löschen des Landes",
            "deleted_error_message" =>
                "Beim Löschen des Landes ist ein Fehler aufgetreten",
        ],
        "validations" => [
            "name_ar_required" => "Ländername auf Arabisch ist erforderlich",
            "name_ar_string" =>
                "Der arabische Ländername muss eine Zeichenfolge sein",
            "name_ar_min" =>
                "Die Mindestanzahl von Buchstaben im Namen des arabischen Landes beträgt mindestens 3 Buchstaben",
            "name_en_required" => "Ländername in Englisch ist erforderlich",
            "name_en_string" =>
                "Der englische Ländername muss eine Zeichenfolge sein",
            "name_en_min" =>
                "Die Mindestanzahl von Buchstaben im englischen Ländernamen beträgt mindestens 3 Buchstaben",
            "code_required" => "Ländercode ist erforderlich",
            "code_string" => "Der Ländercode muss vom Typ String sein",
            "code_min" =>
                "Die Mindestzeichenanzahl für den Ländercode beträgt mindestens 2 Zeichen",
        ],
        "vat_percentage" => "Mehrwertsteuer (%)",
    ],
    "cities" => [
        "name"=>"Der Name",
        "title" => "die Städte",
        "single_title" => "Stadt",
        "all_cities" => "Alle Städte",
        "manage_cities" => "Städteverwaltung",
        "id" => "Stadt-ID",
        "name_ar" => "Arabischer Name",
        "name_en" => "Der Name ist auf Englisch",
        "is_active" => "die Bedingung",
        "yes" => "Ja",
        "no" => "NEIN",
        "create" => "Erstellen Sie eine neue Stadt",
        "update" => "Ändern Sie eine Stadt",
        "search" => "Forschung",
        "all" => "alle",
        "filter" => "filtern",
        "not_found" => "Nichts",
        "show" => "Stadtdaten anzeigen",
        "delete" => "löschen",
        "active" => "aktiv",
        "inactive" => "nicht aktiv",
        "filter_is_active" => "Nach Status filtern",
        "choose_state" => "Wählen Sie das Bundesland der Stadt aus",
        "choose_area" => "Wählen Sie die Region aus",
        "area_id" => "Region",
        "torod_city_id" => "Die Stadtkennung des Paketunternehmens",
        "areas_cities" => "Die Stadtteile",
        "delete_modal" => [
            "title" => "Sind Sie dabei, eine Stadt zu löschen?",
            "description" =>
                "Durch das Löschen Ihrer Bewerbung werden alle Ihre Informationen aus unserer Datenbank entfernt.",
        ],
        "messages" => [
            "created_successfully_title" =>
                "Die Stadt hat sich erfolgreich etabliert",
            "created_successfully_body" =>
                "Die Stadt hat sich erfolgreich etabliert",
            "created_error_title" => "Fehler beim Erstellen der Stadt",
            "created_error_body" =>
                "Beim Erstellen der Stadt ist etwas schief gelaufen",
            "updated_successfully_title" =>
                "Die Stadt wurde erfolgreich geändert",
            "updated_successfully_body" =>
                "Die Stadt wurde erfolgreich geändert",
            "updated_error_title" => "Fehler beim Ändern der Stadt",
            "updated_error_body" =>
                "Beim Ändern der Stadt ist ein Fehler aufgetreten",
            "deleted_successfully_title" =>
                "Die Stadt wurde erfolgreich gelöscht",
            "deleted_successfully_message" =>
                "Die Stadt wurde erfolgreich gelöscht",
            "deleted_error_title" => "Fehler beim Löschen der Stadt",
            "deleted_error_message" =>
                "Beim Löschen der Stadt ist ein Fehler aufgetreten",
            "cannot_delete_city_title" => "Sie können die Stadt nicht löschen",
            "cannot_delete_city_body" =>
                "Eine mit einem Liefergebiet verknüpfte Stadt kann nicht gelöscht werden",
        ],
        "validations" => [
            "name_ar_required" => "Stadtname auf Arabisch ist erforderlich",
            "name_ar_string" =>
                "Der arabische Städtename muss eine Zeichenfolge sein",
            "name_ar_min" =>
                "Die Mindestanzahl von Buchstaben im arabischen Städtenamen beträgt mindestens 3 Buchstaben",
            "name_en_required" => "Stadtname in Englisch ist erforderlich",
            "name_en_string" =>
                "Der englische Städtename muss eine Zeichenfolge sein",
            "name_en_min" =>
                "Die Mindestanzahl von Buchstaben im englischen Städtenamen beträgt mindestens 3 Buchstaben",
            "country_id_required" => "Der Staat ist gefordert",
            "torod_city_id_string" =>
                "Die Stadtkennung des Paketunternehmens muss ein Textwert sein",
        ],
    ],
    "areas" => [
        "title" => "Regionen",
        "single_title" => "Region",
        "all_areas" => "Alle sprechen",
        "manage_areas" => "Sprechermanagement",
        "id" => "Regions-ID",
        "name_ar" => "Arabischer Name",
        "name_en" => "Der Name ist auf Englisch",
        "yes" => "Ja",
        "no" => "NEIN",
        "create" => "Erstellen Sie eine neue Region",
        "update" => "Bereich bearbeiten",
        "search" => "Forschung",
        "all" => "alle",
        "filter" => "filtern",
        "not_found" => "Nichts",
        "show" => "Bereichsdaten anzeigen",
        "delete" => "löschen",
        "choose_state" => "Wählen Sie das Bundesland der Region aus",
        "choose_country" => "Land auswählen",
        "country_id" => "Land",
        "is_active" => "die Bedingung",
        "active" => "aktiv",
        "inactive" => "nicht aktiv",
        "delete_modal" => [
            "title" => "Sie sind dabei, pixelated zu löschen",
            "description" =>
                "Durch das Löschen Ihrer Bewerbung werden alle Ihre Informationen aus unserer Datenbank entfernt.",
        ],
        "messages" => [
            "created_successfully_title" =>
                "Der Bereich wurde erfolgreich erstellt",
            "created_successfully_body" =>
                "Der Bereich wurde erfolgreich erstellt",
            "created_error_title" => "Fehler beim Erstellen der Region",
            "created_error_body" =>
                "Beim Erstellen der Region ist ein Fehler aufgetreten",
            "updated_successfully_title" =>
                "Die Region wurde erfolgreich geändert",
            "updated_successfully_body" =>
                "Die Region wurde erfolgreich geändert",
            "updated_error_title" => "Fehler beim Ändern der Region",
            "updated_error_body" =>
                "Beim Ändern der Region ist ein Fehler aufgetreten",
            "deleted_successfully_title" =>
                "Die Region wurde erfolgreich gelöscht",
            "deleted_successfully_message" =>
                "Die Region wurde erfolgreich gelöscht",
            "deleted_error_title" => "Fehler beim Löschen der Region",
            "deleted_error_message" =>
                "Beim Löschen der Region ist ein Fehler aufgetreten",
        ],
        "validations" => [
            "name_ar_required" =>
                "Der Name der Region auf Arabisch ist erforderlich",
            "name_ar_string" =>
                "Der Name der arabischen Region muss eine Zeichenfolge sein",
            "name_ar_min" =>
                "Die Mindestanzahl von Buchstaben im Namen der arabischen Region beträgt mindestens 3 Buchstaben",
            "name_en_required" =>
                "Der Name der Region in englischer Sprache ist erforderlich",
            "name_en_string" =>
                "Der englische Regionsname muss eine Zeichenfolge sein",
            "name_en_min" =>
                "Die Mindestanzahl von Buchstaben im englischen Namen der Region beträgt mindestens 3 Buchstaben",
            "country_id_required" => "Der Staat ist gefordert",
        ],
    ],
    "static-content" => [
        "title" => "Websiten Inhalt",
        "about-us" => [
            'title' => 'Abschnittstitel',
            'paragraph' => 'Teilebeschreibung',
            "page-title" => "Verwalten Sie eine Seite über die Plattform",
            "create" => "Fügen Sie einen Abschnitt über die Plattform hinzu",
            "search" => "Forschung",
            "title_ar" => "Der Titel des Abschnitts ist Arabisch",
            "title_en" => "Der Titel des Abschnitts ist Englisch",
            "show" => "Sehen Sie sich einen Abschnitt über die Plattform an",
            "edit" => "Ändern Sie einen Abschnitt über die Plattform",
            "delete_modal" => [
                "title" => "Löschen Sie einen Abschnitt auf der Plattform",
                "description" =>
                    "Möchten Sie einen Abschnitt auf der Plattform löschen?",
            ],
            "delete" => "Löschen Sie einen Abschnitt auf der Plattform",
            "paragraph_ar" => "Abschnitt Beschreibung Arabisch",
            "paragraph_en" => "Abschnittsbeschreibung Englisch",
        ],
        "validations" => [
            "title_ar_required" => "Abschnittstitel Arabisch ist erforderlich",
            "title_ar_string" =>
                "Der Titel des Abschnitts muss eine arabische Zeichenfolge sein",
            "title_ar_min" =>
                "Die Mindestzeichenzahl für den arabischen Abschnittstitel beträgt mindestens 3 Zeichen",
            "title_ar_max" =>
                "Die größte Anzahl von Buchstaben im arabischen Abschnittstitel beträgt höchstens 600 Zeichen",
            "title_en_required" => "Abschnittstitel Englisch ist erforderlich",
            "title_en_string" =>
                "Der Abschnittstitel muss eine englische Zeichenfolge sein",
            "title_en_min" =>
                "Die Mindestzeichenzahl für den englischen Abschnittstitel beträgt mindestens 3 Zeichen",
            "title_en_max" =>
                "Die größte Anzahl von Buchstaben im Titel des Abschnitts ist Englisch, höchstens 600 Zeichen",
            "paragraph_en_required" =>
                "Abschnitt Beschreibung Englisch ist erforderlich",
            "paragraph_en_string" =>
                "Die Beschreibung des Abschnitts muss im englischen Typ einer Zeichenfolge sein",
            "paragraph_en_min" =>
                "Die Mindestzeichenzahl für die englische Abschnittsbeschreibung beträgt mindestens 50 Zeichen",
            "paragraph_en_max" =>
                "Die maximale Zeichenzahl für die englische Abschnittsbeschreibung beträgt 1000 Zeichen oder mehr",
            "paragraph_ar_required" =>
                "Abschnitt Beschreibung Arabisch ist erforderlich",
            "paragraph_ar_string" =>
                "Die Beschreibung des Abschnitts muss Arabisch vom Typ String sein",
            "paragraph_ar_min" =>
                "Die Mindestzeichenzahl für die arabische Abschnittsbeschreibung beträgt mindestens 50 Zeichen",
            "paragraph_ar_max" =>
                "Die maximale Zeichenzahl für die Beschreibung des arabischen Teils beträgt 1000 Zeichen oder mehr",
        ],
        "messages" => [
            "success" => "erfolgreichen Betrieb",
            "warning" => "Warnung",
            "error" => "Fehler",
            "section-created" => "Der Abschnitt wurde erfolgreich erstellt",
            "section-updated" => "Der Abschnitt wurde erfolgreich geändert",
            "section-deleted" => "Der Abschnitt wurde erfolgreich gelöscht",
            "section-not-deleted" =>
                "Der Abschnitt kann derzeit nicht gelöscht werden",
        ],
        "privacy-policy" => [
            'title' => 'Abschnittstitel',
            'paragraph' => 'Teilebeschreibung',
            "page-title" =>
                "Verwalten Sie die Seite mit den Datenschutzrichtlinien",
            "create" =>
                "Fügen Sie einen Abschnitt zur Datenschutzrichtlinie hinzu",
            "search" => "Forschung",
            "title_ar" => "Der Titel des Abschnitts ist Arabisch",
            "title_en" => "Der Titel des Abschnitts ist Englisch",
            "show" => "Sehen Sie sich den Abschnitt Datenschutzrichtlinie an",
            "edit" => "Ändern Sie den Abschnitt Datenschutzrichtlinie",
            "delete_modal" => [
                "title" => "Löschen Sie den Abschnitt Datenschutzrichtlinie",
                "description" =>
                    "Möchten Sie den Abschnitt Datenschutzrichtlinie löschen?",
            ],
            "delete" => "Löschen Sie den Abschnitt Datenschutzrichtlinie",
            "paragraph_ar" => "Abschnitt Beschreibung Arabisch",
            "paragraph_en" => "Abschnittsbeschreibung Englisch",
        ],
        "usage-agreement" => [
            'title' => 'Abschnittstitel',
            'paragraph' => 'Teilebeschreibung',
            "page-title" => "Verwalten Sie die Nutzungsvereinbarungsseite",
            "create" =>
                "Fügen Sie einen Abschnitt der Nutzungsvereinbarung hinzu",
            "search" => "Forschung",
            "title_ar" => "Der Titel des Abschnitts ist Arabisch",
            "title_en" => "Der Titel des Abschnitts ist Englisch",
            "show" => "Sehen Sie sich den Abschnitt Nutzungsbedingungen an",
            "edit" => "Änderung des Abschnitts „Nutzungsvereinbarung“.",
            "delete_modal" => [
                "title" => "Löschen Sie den Abschnitt Nutzungsbedingungen",
                "description" =>
                    "Möchten Sie den Abschnitt Nutzungsvereinbarung löschen?",
            ],
            "delete" => "Löschen Sie den Abschnitt Nutzungsbedingungen",
            "paragraph_ar" => "Abschnitt Beschreibung Arabisch",
            "paragraph_en" => "Abschnittsbeschreibung Englisch",
        ],
    ],
    "qnas" => [
        "question" => 'Häufig gestellte Fragen',
        "answer"=>'Antwort auf eine häufig gestellte Frage',
        "title" => "häufige Fragen",
        "single_title" => "Frage",
        "all_products" => "Alle Produkte",
        "manage_qnas" => "Häufig gestellte Fragen Verwaltung",
        "id" => "Fragen-ID",
        "name_ar" => "Arabischer Name",
        "name_en" => "Der Name ist auf Englisch",
        "desc_ar" => "Beschreibung einer Frage auf Arabisch",
        "desc_en" => "Beschreibung der Frage auf Englisch",
        "is_featured" => "Vorgestelltes Produkt",
        "is_active" => "die Bedingung",
        "active" => "aktiv",
        "inactive" => "Inaktiv",
        "price" => "der Preis",
        "unitPrice" => "Einzelpreis",
        "total" => "Gesamtfragepreis",
        "order" => "Rangfolge",
        "category" => "Abschnitt",
        "vendor" => "das Geschäft",
        "pending" => "mein Nachbar",
        "in_review" => "unter Auswertung",
        "holded" => "hängend",
        "yes" => "Ja",
        "no" => "NEIN",
        "create" => "Erstellen Sie eine neue Frage",
        "update" => "Ändern Sie eine Frage",
        "search" => "Forschung",
        "all" => "alle",
        "filter" => "filtern",
        "created_at_select" => "Wählen Sie ein Datum aus",
        "not_found" => "Nichts",
        "show" => "ein Angebot",
        "delete" => "löschen",
        "edit" => "Änderung",
        "vendor_id" => "das Geschäft",
        "arabic_date" => "Arabische Daten",
        "english_date" => "Daten in Englisch",
        "choose_category" => "Wählen Sie eine Abteilung",
        "image" => "Wählen Sie das Fragebild aus",
        "image_title" => "Ziehen Sie das Fragebild hierher",
        "answer_ar" => "Die Antwort ist auf Arabisch",
        "answer_en" => "Die Antwort ist auf Englisch",
        "question_en" => "Die Frage ist auf Englisch",
        "question_ar" => "Die Frage ist auf Arabisch",
        "delete_modal" => [
            "title" => "Sie sind dabei, eine Frage zu löschen",
            "description" =>
                "Wenn Sie Ihre Anfrage löschen, werden alle Informationen für diese Frage entfernt.",
        ],
        "validations" => [
            "question_ar_required" => "Die Frage ist erforderlich",
            "question_ar_string" => "Die Frage muss Text sein",
            "question_ar_min" =>
                "Die Frage muss mindestens 3 Buchstaben lang sein",
            "question_ar_max" =>
                "Die Frage darf höchstens 600 Zeichen lang sein",
            "answer_ar_required" => "Die Antwort ist erforderlich",
            "answer_ar_string" => "Die Antwort muss Text sein",
            "answer_ar_min" =>
                "Die Antwort muss aus mindestens 3 Buchstaben bestehen",
            "answer_ar_max" =>
                "Die Antwort darf höchstens 1000 Zeichen lang sein",
            "question_en_required" => "Die Frage ist erforderlich",
            "question_en_string" => "Die Frage muss Text sein",
            "question_en_min" =>
                "Die Frage muss mindestens 3 Buchstaben lang sein",
            "question_en_max" =>
                "Die Frage darf höchstens 600 Zeichen lang sein",
            "answer_en_required" => "Die Antwort ist erforderlich",
            "answer_en_string" => "Die Antwort muss Text sein",
            "answer_en_min" =>
                "Die Antwort muss aus mindestens 3 Buchstaben bestehen",
            "answer_en_max" =>
                "Die Antwort darf höchstens 1000 Zeichen lang sein",
        ],
        "messages" => [
            "created_successfully_title" => "Frage erfolgreich erstellt",
            "created_successfully_body" => "Frage erfolgreich erstellt",
            "created_error_title" => "Fehler beim Erstellen der Frage",
            "created_error_body" =>
                "Beim Erstellen der Frage ist ein Fehler aufgetreten",
            "updated_successfully_title" => "Frage erfolgreich geändert",
            "updated_successfully_body" => "Frage erfolgreich geändert",
            "updated_error_title" => "Fehler beim Bearbeiten der Frage",
            "updated_error_body" =>
                "Beim Bearbeiten der Frage ist ein Fehler aufgetreten",
            "deleted_successfully_title" =>
                "Die Frage wurde erfolgreich gelöscht",
            "deleted_successfully_message" =>
                "Die Frage wurde erfolgreich gelöscht",
            "deleted_error_title" => "Fehler beim Löschen der Frage",
            "deleted_error_message" =>
                "Beim Löschen der Frage ist ein Fehler aufgetreten",
        ],
    ],
    "rates_title" => "Auswertung",
    "no_data" => "Nichts",
    "admin_approved_state" => [
        "pending" => "Genehmigung läuft",
        "approved" => "OK",
        "rejected" => "inakzeptabel",
    ],
    "productRates" => [
        "last_admin_edit" =>
            "Datum der letzten Änderung durch den Administrator",
        "title" => "Produktbewertung",
        "single_title" => "Produktevaluation",
        "all_productRates" => "Alle Produktbewertungen",
        "manage_productRates" => "Verwalten Sie Produktbewertungen",
        "state_apporved" => "Es wurde akzeptiert",
        "state_not_apporved" => "Nicht akzeptiert",
        "id" => "Bewertungs-ID",
        "rate" => "Auswertung",
        "comment" => "Kundenkommentar",
        "user_id" => "Kundenname",
        "product_id" => "Produktname",
        "reason" => "der Grund",
        "admin_id" => "Admin-Name",
        "admin_comment" => "Admin-Kommentar",
        "admin_approved" => "Freigabestand",
        "reporting" => "Benachrichtigung",
        "yes" => "Ja",
        "no" => "NEIN",
        "update" => "Auswertungsdaten ändern",
        "search" => "Forschung",
        "all" => "alle",
        "filter" => "filtern",
        "not_found" => "Nichts",
        "show" => "Auswertungsdaten ansehen",
        "delete" => "löschen",
        "active" => "aktiv",
        "inactive" => "nicht aktiv",
        "filter_is_active" => "Nach Status filtern",
        "not_answer" => "Der Administrator hat noch nicht genehmigt",
        "choose_state" => "Bewertungsstatus auswählen",
        "delete_modal" => [
            "title" => "Sie sind dabei, eine Produktbewertung zu löschen",
            "description" =>
                "Durch das Löschen Ihrer Bewerbung werden alle Ihre Informationen aus unserer Datenbank entfernt.",
        ],
        "messages" => [
            "created_successfully_title" => "Bewertung erfolgreich erstellt",
            "created_successfully_body" => "Bewertung erfolgreich erstellt",
            "created_error_title" => "Fehler beim Erstellen der Bewertung",
            "created_error_body" =>
                "Beim Erstellen der Bewertung ist ein Fehler aufgetreten",
            "updated_successfully_title" =>
                "Bewertung wurde erfolgreich geändert",
            "updated_successfully_body" =>
                "Bewertung wurde erfolgreich geändert",
            "updated_error_title" => "Fehler beim Ändern der Bewertung",
            "updated_error_body" =>
                "Beim Ändern der Bewertung ist ein Fehler aufgetreten",
            "deleted_successfully_title" =>
                "Die Bewertung wurde erfolgreich gelöscht",
            "deleted_successfully_message" =>
                "Die Bewertung wurde erfolgreich gelöscht",
            "deleted_error_title" => "Fehler beim Löschen der Bewertung",
            "deleted_error_message" =>
                "Beim Löschen der Bewertung ist etwas schief gelaufen",
        ],
        "validations" => [
            "admin_comment_string" =>
                "Der Kommentar des Administrators muss vom Typ Text sein",
            "admin_comment_min" =>
                "Die Mindestanzahl von Zeichen für einen Admin-Kommentar beträgt 3 Buchstaben",
            "admin_approved_boolean" =>
                "Der Feldtyp dieses Felds muss ein boolescher Wert sein",
            "admin_id_numeric" =>
                "Der Feldtyp dieses Felds muss ein boolescher Wert sein",
        ],
    ],
    "vendorRates" => [
        "last_admin_edit" =>
            "Datum der letzten Änderung durch den Administrator",
        "title" => "Bewertung speichern",
        "single_title" => "Händlerbewertung",
        "all_vendorRates" => "Alle Shop-Bewertungen",
        "manage_vendorRates" => "Verwaltung von Store-Bewertungen",
        "state_apporved" => "Es wurde akzeptiert",
        "state_not_apporved" => "Nicht akzeptiert",
        "id" => "Bewertungs-ID",
        "rate" => "Auswertung",
        "comment" => "Kundenkommentar",
        "user_id" => "Kundenname",
        "vendor_id" => "Händlername",
        "admin_id" => "Admin-Name",
        "admin_comment" => "Admin-Kommentar",
        "admin_approved" => "Freigabestand",
        "yes" => "Ja",
        "no" => "NEIN",
        "update" => "Auswertungsdaten ändern",
        "search" => "Forschung",
        "all" => "alle",
        "filter" => "filtern",
        "not_found" => "Nichts",
        "show" => "Auswertungsdaten ansehen",
        "delete" => "löschen",
        "active" => "aktiv",
        "inactive" => "nicht aktiv",
        "filter_is_active" => "Nach Status filtern",
        "not_answer" => "Der Administrator hat noch nicht genehmigt",
        "choose_state" => "Bewertungsstatus auswählen",
        "delete_modal" => [
            "title" => "Sie sind dabei, eine Händlerbewertung zu löschen",
            "description" =>
                "Durch das Löschen Ihrer Bewerbung werden alle Ihre Informationen aus unserer Datenbank entfernt.",
        ],
        "messages" => [
            "created_successfully_title" => "Bewertung erfolgreich erstellt",
            "created_successfully_body" => "Bewertung erfolgreich erstellt",
            "created_error_title" => "Fehler beim Erstellen der Bewertung",
            "created_error_body" =>
                "Beim Erstellen der Bewertung ist ein Fehler aufgetreten",
            "updated_successfully_title" =>
                "Bewertung wurde erfolgreich geändert",
            "updated_successfully_body" =>
                "Bewertung wurde erfolgreich geändert",
            "updated_error_title" => "Fehler beim Ändern der Bewertung",
            "updated_error_body" =>
                "Beim Ändern der Bewertung ist ein Fehler aufgetreten",
            "deleted_successfully_title" =>
                "Die Bewertung wurde erfolgreich gelöscht",
            "deleted_successfully_message" =>
                "Die Bewertung wurde erfolgreich gelöscht",
            "deleted_error_title" => "Fehler beim Löschen der Bewertung",
            "deleted_error_message" =>
                "Beim Löschen der Bewertung ist etwas schief gelaufen",
        ],
        "validations" => [
            "admin_comment_string" =>
                "Der Kommentar des Administrators muss vom Typ Text sein",
            "admin_comment_min" =>
                "Die Mindestanzahl von Zeichen für einen Admin-Kommentar beträgt 3 Buchstaben",
            "admin_approved_boolean" =>
                "Der Feldtyp dieses Felds muss ein boolescher Wert sein",
            "admin_id_numeric" =>
                "Der Feldtyp dieses Felds muss ein boolescher Wert sein",
        ],
    ],
    "recipes" => [
        "body" => "inhalt",
        'short_desc'=>'Kurzbeschreibung',
        "title" => "Rezepte",
        "single_title" => "das Rezept",
        "all_recipes" => "Alle Rezepte",
        "manage_recipes" => "Rezeptverwaltung",
        "id" => "Rezept-ID",
        "body_ar" => "Arabischer Inhalt",
        "body_en" => "Inhalt auf Englisch",
        "image" => "Wählen Sie ein Beschreibungsbild aus",
        "most_visited" => "meist besuchte",
        "image_for_show" => "Rezeptfoto",
        "is_active" => "die Bedingung",
        "yes" => "Ja",
        "no" => "NEIN",
        "create" => "Erstellen Sie ein neues Rezept",
        "update" => "Rezeptänderung",
        "search" => "Forschung",
        "all" => "alle",
        "filter" => "filtern",
        "not_found" => "Nichts",
        "show" => "Rezeptdaten anzeigen",
        "edit" => "Änderung",
        "delete" => "löschen",
        "active" => "aktiv",
        "inactive" => "nicht aktiv",
        "filter_is_active" => "Nach Status filtern",
        "choose_state" => "Rezeptstatus auswählen",
        "choose_country" => "Rezept auswählen",
        "country_id" => "das Rezept",
        "areas_cities" => "Die Stadtteile",
        "title_ar" => "Die Adresse ist arabisch",
        "title_en" => "Die Adresse ist englisch",
        "short_desc_ar" => "Die Kurzbezeichnung ist Arabisch",
        "short_desc_en" => "Die Kurzbeschreibung ist auf Englisch",
        "delete_modal" => [
            "title" => "Möchten Sie ein Rezept löschen?",
            "description" =>
                "Durch das Löschen Ihrer Bewerbung werden alle Ihre Informationen aus unserer Datenbank entfernt.",
        ],
        "messages" => [
            "created_successfully_title" => "Rezept erfolgreich generiert",
            "created_successfully_body" => "Rezept erfolgreich generiert",
            "created_error_title" => "Fehler beim Erstellen des Rezepts",
            "created_error_body" =>
                "Beim Erstellen des Rezepts ist ein Fehler aufgetreten",
            "updated_successfully_title" =>
                "Das Rezept wurde erfolgreich geändert",
            "updated_successfully_body" =>
                "Das Rezept wurde erfolgreich geändert",
            "updated_error_title" => "Fehler beim Ändern des Rezepts",
            "updated_error_body" =>
                "Beim Ändern des Rezepts ist ein Fehler aufgetreten",
            "deleted_successfully_title" =>
                "Das Rezept wurde erfolgreich gelöscht",
            "deleted_successfully_message" =>
                "Das Rezept wurde erfolgreich gelöscht",
            "deleted_error_title" => "Fehler beim Löschen des Rezepts",
            "deleted_error_message" =>
                "Beim Löschen des Rezepts ist etwas schief gelaufen",
        ],
        "validations" => [
            "title_ar_required" => "Titel in Arabisch ist erforderlich",
            "title_en_required" => "Englischer Titel ist erforderlich",
            "title_ar_min" => "Der Titel muss mindestens 3 Zeichen lang sein",
            "title_en_min" => "Der Titel muss mindestens 3 Zeichen lang sein",
            "title_ar_max" => "Der Titel darf höchstens 600 Zeichen lang sein",
            "title_en_max" => "Der Titel darf höchstens 600 Zeichen lang sein",
            "body_ar_required" => "Arabische Inhalte sind erforderlich",
            "body_en_required" => "Englische Inhalte sind erforderlich",
            "short_desc_ar_required" =>
                "Eine kurze Beschreibung auf Arabisch ist erforderlich",
            "short_desc_en_required" =>
                "Eine kurze Beschreibung in Englisch ist erforderlich",
            "short_desc_ar_min" =>
                "Die Beschreibung muss mindestens 3 Zeichen lang sein",
            "short_desc_en_min" =>
                "Die Beschreibung muss mindestens 3 Zeichen lang sein",
            "body_ar_max" =>
                "Die Beschreibung darf höchstens 1000 Zeichen lang sein",
            "body_en_max" =>
                "Die Beschreibung darf höchstens 1000 Zeichen lang sein",
        ],
    ],
    "blogPosts" => [
        "body" => "inhalt",
        'short_desc'=>'Kurzbeschreibung',
        "title" => "bloggen",
        "single_title" => "Fäden",
        "all_recipes" => "Alle Rezepte",
        "manage_blogPosts" => "Blog-Verwaltung",
        "id" => "Rezept-ID",
        "body_ar" => "Arabischer Inhalt",
        "body_en" => "Inhalt auf Englisch",
        "image" => "Wählen Sie ein Beschreibungsbild aus",
        "most_visited" => "meist besuchte",
        "image_for_show" => "Rezeptfoto",
        "is_active" => "die Bedingung",
        "yes" => "Ja",
        "no" => "NEIN",
        "create" => "Erstellen Sie ein neues Thema",
        "update" => "Ändern Sie ein Design",
        "search" => "Forschung",
        "all" => "alle",
        "filter" => "filtern",
        "not_found" => "Nichts",
        "show" => "Themendaten anzeigen",
        "edit" => "Änderung",
        "delete" => "löschen",
        "active" => "aktiv",
        "inactive" => "nicht aktiv",
        "filter_is_active" => "Nach Status filtern",
        "choose_state" => "Wählen Sie einen Themenfall",
        "choose_country" => "Wähle ein Thema",
        "country_id" => "Thema",
        "areas_cities" => "Die Stadtteile",
        "title_ar" => "Die Adresse ist arabisch",
        "title_en" => "Die Adresse ist englisch",
        "short_desc_ar" => "Die Kurzbezeichnung ist Arabisch",
        "short_desc_en" => "Die Kurzbeschreibung ist auf Englisch",
        "delete_modal" => [
            "title" => "Möchten Sie ein Thema löschen?",
            "description" =>
                "Durch das Löschen Ihrer Bewerbung werden alle Ihre Informationen aus unserer Datenbank entfernt.",
        ],
        "messages" => [
            "created_successfully_title" => "Thema erfolgreich erstellt",
            "created_successfully_body" => "Thema erfolgreich erstellt",
            "created_error_title" => "Fehler beim Erstellen des Themas",
            "created_error_body" =>
                "Beim Erstellen des Themas ist ein Fehler aufgetreten",
            "updated_successfully_title" => "Thread wurde erfolgreich geändert",
            "updated_successfully_body" => "Thread wurde erfolgreich geändert",
            "updated_error_title" => "Fehler beim Bearbeiten des Themas",
            "updated_error_body" =>
                "Beim Bearbeiten des Designs ist ein Fehler aufgetreten",
            "deleted_successfully_title" =>
                "Das Thema wurde erfolgreich gelöscht",
            "deleted_successfully_message" =>
                "Das Thema wurde erfolgreich gelöscht",
            "deleted_error_title" => "Fehler beim Löschen des Themas",
            "deleted_error_message" =>
                "Beim Löschen des Themas ist etwas schief gelaufen",
        ],
        "validations" => [
            "title_ar_required" => "Titel in Arabisch ist erforderlich",
            "title_en_required" => "Englischer Titel ist erforderlich",
            "title_ar_min" => "Der Titel muss mindestens 3 Zeichen lang sein",
            "title_en_min" => "Der Titel muss mindestens 3 Zeichen lang sein",
            "body_ar_required" => "Arabische Inhalte sind erforderlich",
            "body_en_required" => "Englische Inhalte sind erforderlich",
            "short_desc_ar_required" =>
                "Eine kurze Beschreibung auf Arabisch ist erforderlich",
            "short_desc_en_required" =>
                "Eine kurze Beschreibung in Englisch ist erforderlich",
            "short_desc_ar_min" =>
                "Die Beschreibung muss mindestens 3 Zeichen lang sein",
            "short_desc_en_min" =>
                "Die Beschreibung muss mindestens 3 Zeichen lang sein",
        ],
    ],
    "productQuantities" => [
        "name"=>"Der Name",
        "title" => "Produktmaßeinheiten",
        "single_title" => "Messeinheit",
        "all_cities" => "Alle Maßeinheiten",
        "manage_productQuantities" => "Verwalten Sie Produktmaßeinheiten",
        "id" => "Einheiten-ID",
        "name_ar" => "Arabischer Name",
        "name_en" => "Der Name ist auf Englisch",
        "is_active" => "die Bedingung",
        "yes" => "Ja",
        "no" => "NEIN",
        "create" => "Erstellen Sie eine neue Einheit",
        "update" => "Alleine modifizieren",
        "search" => "Forschung",
        "all" => "alle",
        "filter" => "filtern",
        "not_found" => "Nichts",
        "show" => "Gerätedaten anzeigen",
        "delete" => "löschen",
        "active" => "aktiv",
        "inactive" => "nicht aktiv",
        "filter_is_active" => "Nach Status filtern",
        "choose_state" => "Wählen Sie den Zustand der Einheit aus",
        "delete_modal" => [
            "title" => "Sie sind im Begriff, allein zu löschen",
            "description" =>
                "Durch das Löschen Ihrer Bewerbung werden alle Ihre Informationen aus unserer Datenbank entfernt.",
        ],
        "messages" => [
            "created_successfully_title" =>
                "Die Einheit wurde erfolgreich erstellt",
            "created_successfully_body" =>
                "Die Einheit wurde erfolgreich erstellt",
            "created_error_title" => "Fehler beim Erstellen der Einheit",
            "created_error_body" =>
                "Beim Erstellen des Moduls ist ein Fehler aufgetreten",
            "updated_successfully_title" =>
                "Das Gerät wurde erfolgreich modifiziert",
            "updated_successfully_body" =>
                "Das Gerät wurde erfolgreich modifiziert",
            "updated_error_title" => "Fehler beim Ändern der Einheit",
            "updated_error_body" =>
                "Beim Modifizieren des Moduls ist ein Fehler aufgetreten",
            "deleted_successfully_title" =>
                "Die Einheit wurde erfolgreich gelöscht",
            "deleted_successfully_message" =>
                "Die Einheit wurde erfolgreich gelöscht",
            "deleted_error_title" => "Fehler beim Löschen der Einheit",
            "deleted_error_message" =>
                "Beim Löschen des Moduls ist ein Fehler aufgetreten",
        ],
        "validations" => [
            "name_ar_required" =>
                "Der Name der Einheit in Arabisch ist erforderlich",
            "name_ar_string" =>
                "Der Name des arabischen Moduls muss vom Typ String sein",
            "name_ar_min" =>
                "Die Mindestanzahl von Buchstaben im Namen der arabischen Einheit beträgt mindestens 3 Buchstaben",
            "name_en_required" => "Einheitsname in Englisch ist erforderlich",
            "name_en_string" =>
                "Der englische Modulname muss vom Typ String sein",
            "name_en_min" =>
                "Die Mindestanzahl von Buchstaben im englischen Einheitennamen beträgt mindestens 3 Buchstaben",
            "country_id_required" => "Der Staat ist gefordert",
            "is_active_required" => "Der Status ist erforderlich",
        ],
    ],
    "wareHouseRequests" => [
        "title" => "Speicheranfragen",
        "single_title" => "Traurige Bitte",
        "all_wareHouseRequests" => "Alle Speicheranforderungen",
        "manage_wareHouseRequests" => "Speicheranfragen verwalten",
        "products_count" => "Die Anzahl der Produkte",
        "id" => "Auftragsnummer",
        "next" => "der nächste",
        "vendor" => "das Geschäft",
        "choose_vendor" => "Laden auswählen",
        "choose_product" => "Wählen Sie das Produkt aus",
        "name_ar" => "Arabischer Produktname",
        "name_en" => "Produktname auf Englisch",
        "product" => "das Produkt",
        "status" => "die Bedingung",
        "created_at" => "Datum erstellt",
        "created_by" => "von",
        "qnt" => "Die Anzahl der Kerne",
        "mnfg_date" => "Produktionsdatum",
        "expire_date" => "Verfallsdatum",
        "yes" => "Ja",
        "no" => "NEIN",
        "create" => "Erstellen Sie eine neue Speicheranfrage",
        "update" => "Ändern Sie eine Speicheranforderung",
        "search" => "Forschung",
        "all" => "alle",
        "filter" => "filtern",
        "not_found" => "Nichts",
        "show" => "Speicheranforderungsdaten anzeigen",
        "delete" => "löschen",
        "active" => "aktiv",
        "inactive" => "nicht aktiv",
        "filter_is_active" => "Nach Status filtern",
        "choose_state" => "Wählen Sie den Status der Speicheranfrage",
        "requestItems" => "Produkte",
        "vendor-no-products" =>
            "Dieser Händler hat keine Produkte, bitte wählen Sie einen anderen Händler",
        "product_count" => "Anzahl der Produkte",
        "delete_modal" => [
            "title" => "Sie sind dabei, eine Speicheranfrage zu löschen",
            "description" =>
                "Durch das Löschen Ihrer Bewerbung werden alle Ihre Informationen aus unserer Datenbank entfernt.",
        ],
        "messages" => [
            "created_successfully_title" =>
                "Eine Speicheranforderung wurde erfolgreich erstellt",
            "created_successfully_body" =>
                "Eine Speicheranforderung wurde erfolgreich erstellt",
            "created_error_title" =>
                "Fehler beim Erstellen der Speicheranforderung",
            "created_error_body" =>
                "Beim Erstellen einer Speicheranfrage ist ein Fehler aufgetreten",
            "updated_successfully_title" =>
                "Eine Speicheranforderung wurde erfolgreich geändert",
            "updated_successfully_body" =>
                "Eine Speicheranforderung wurde erfolgreich geändert",
            "updated_error_title" =>
                "Fehler beim Ändern der Speicheranforderung",
            "updated_error_body" =>
                "Beim Ändern einer Speicheranforderung ist ein Fehler aufgetreten",
            "deleted_successfully_title" =>
                "Eine Speicheranfrage wurde erfolgreich gelöscht",
            "deleted_successfully_message" =>
                "Eine Speicheranfrage wurde erfolgreich gelöscht",
            "deleted_error_title" =>
                "Fehler beim Löschen einer Speicheranfrage",
            "deleted_error_message" =>
                "Beim Löschen einer Speicheranforderung ist ein Fehler aufgetreten",
        ],
        "validations" => [
            "vendor_id_required" => "Geschäftsname ist erforderlich",
            "product_id_required" =>
                "Der Name der Speicheranforderung auf Arabisch ist erforderlich",
            "qnt_required" =>
                "Der Name der arabischen Speicheranforderung muss vom Typ Zeichenfolge sein",
            "mnfg_date_required" =>
                "Die Mindestbuchstabenzahl für den Namen der arabischen Speicheranfrage beträgt mindestens 3 Buchstaben",
            "expire_date_required" =>
                "Der Name der Speicheranfrage in englischer Sprache ist erforderlich",
            "expire_date_after" =>
                "Das Verfallsdatum muss nach dem Herstellungsdatum liegen",
        ],
    ],
    "sliders" => [
        "manage_sliders" => "Slider-Verwaltung",
        "name" => "der Name",
        "identifire" => "Identifikationsname",
        "id" => "AUSWEIS",
        "type" => "Typ",
        "show" => "ein Angebot",
        "edit" => "Änderung",
        "image" => "Bild hinzufügen",
        "create" => "Erstellen Sie einen Schieberegler",
        "remove" => "Witz",
        "delete" => "Stornierung",
        "identifier" => "AUSWEIS",
        "delete_modal" => [
            "title" => "Sie sind dabei, eine Speicheranfrage zu löschen",
            "description" =>
                "Durch das Löschen Ihrer Bewerbung werden alle Ihre Informationen aus unserer Datenbank entfernt.",
        ],
        "messages" => [
            "created_successfully_title" => "Schieberegler wurde hinzugefügt",
            "created_successfully_body" => "Schieberegler wurde hinzugefügt",
            "updated_successfully_title" => "Slider wurde geändert",
            "updated_successfully_body" => "Slider wurde geändert",
            "deleted_successfully_title" =>
                "Das Bild wurde erfolgreich gelöscht",
            "deleted_successfully_message" =>
                "Das Bild wurde erfolgreich gelöscht",
        ],
    ],
    "carts_list" => "Einkaufskörbe",
    "cart_show" => "Warenkorb ansehen",
    "cart_main_details" => "Hauptkorbdaten",
    "cart_id" => "Einkaufswagen-ID",
    "cart_date" => "Das Datum, an dem der Korb erstellt wurde",
    "cart_price" => "der Preis",
    "cart_products_count" => "Anzahl der Produkte",
    "cart_customer_name" => "Kundenname",
    "cart_last_update" => "Das Datum der letzten Aktualisierung",
    "team_title" => "Arbeitsgruppe",
    "unauthorized_title" => "Sie haben keine Gültigkeit",
    "unauthorized_body" => "Entschuldigung... Sie haben keine Gültigkeit",
    "subAdmins" => [
        "title" => "Systemadministratoren",
        "single_title" => "Systemadministrator",
        "manage_subAdmins" => "Verwalten von Systemadministratoren",
        "rules" => "Supervisor-Rollen",
        "yes" => "Ja",
        "no" => "NEIN",
        "id" => "Supervisor-ID",
        "name" => "der Name",
        "email" => "Email",
        "phone" => "Handy",
        "password" => "Passwort",
        "no_rules_found" => "Derzeit sind keine Rollen vorhanden",
        "avatar" => "Benutzerfoto",
        "create" => "Legen Sie einen neuen Betreuer an",
        "edit" => "Änderung",
        "update" => "Moderator bearbeiten",
        "search" => "Forschung",
        "all" => "alle",
        "filter" => "filtern",
        "not_found" => "Nichts",
        "show" => "Admin-Daten anzeigen",
        "delete" => "löschen",
        "delete_modal" => [
            "title" => "Sie sind dabei, einen Administrator zu löschen",
            "description" =>
                "Durch das Löschen Ihrer Bewerbung werden alle Ihre Informationen aus unserer Datenbank entfernt.",
        ],
        "messages" => [
            "created_successfully_title" => "Supervisor erfolgreich erstellt",
            "created_successfully_body" => "Supervisor erfolgreich erstellt",
            "created_error_title" => "Fehler beim Erstellen des Administrators",
            "created_error_body" =>
                "Beim Erstellen eines Administrators ist ein Fehler aufgetreten",
            "updated_successfully_title" => "Admin wurde erfolgreich geändert",
            "updated_successfully_body" => "Admin wurde erfolgreich geändert",
            "updated_error_title" => "Fehler beim Bearbeiten von admin",
            "updated_error_body" =>
                "Beim Bearbeiten eines Administrators ist ein Fehler aufgetreten",
            "deleted_successfully_title" =>
                "Supervisor wurde erfolgreich entfernt",
            "deleted_successfully_message" =>
                "Supervisor wurde erfolgreich entfernt",
            "deleted_error_title" => "Fehler beim Löschen des Administrators",
            "deleted_error_message" =>
                "Beim Löschen eines Administrators ist ein Fehler aufgetreten",
        ],
        "validations" => [
            "name_required" => "Namensfeld ist erforderlich",
            "name_string" => "Das Namensfeld muss eine Zeichenfolge sein",
            "name_min" =>
                "Die Mindestanzahl von Buchstaben im Namen beträgt 3 Buchstaben",
            "email_required" => "E-Mail-Feld ist erforderlich",
            "email_email" => "Falsches E-Mail-Format",
            "email_unique" => "Porto wurde bereits übernommen",
            "phone_required" => "Handynummer ist erforderlich",
            "phone_min" =>
                "Die Mindestlänge einer Handynummer beträgt 9 Ziffern",
            "password_required" => "Passwortfeld ist erforderlich",
            "password_string" => "Das Passwort muss eine Textzeichenfolge sein",
            "password_min" =>
                "Die Mindestlänge des Passworts beträgt 8 Zeichen oder Zahlen",
            "avatar_image" => "Ungültiges Bildformat",
            "avatar_mimes" => "Zulässige Bilderweiterung ist png, jpeg",
        ],
    ],
    "rules" => [
        "title" => "Ich schalte Moderatoren",
        "single_title" => "Rolle",
        "all_rules" => "Alle Rollen",
        "manage_rules" => "Rollenverwaltung",
        "id" => "Rollen-ID",
        "name_ar" => "Arabischer Name",
        "name_en" => "Der Name ist auf Englisch",
        "yes" => "Ja",
        "no" => "NEIN",
        "create" => "Erstellen Sie eine neue Rolle",
        "update" => "Rollenänderung",
        "search" => "Forschung",
        "all" => "alle",
        "filter" => "filtern",
        "not_found" => "Nichts",
        "show" => "Rollendaten anzeigen",
        "delete" => "löschen",
        "sub-admin" => "Verwaltung",
        "vendor" => "das Geschäft",
        "choose_scope" => "Wählen Sie eine Domäne aus",
        "choose_scope_filter" => "Umfang des Rollenfilters",
        "scope" => "die Reichweite",
        "permissions" => [
            "title" => "Alle Genehmigungen",
            "no_permissions_found" => "Es gibt keine Genehmigungen",
        ],
        "delete_modal" => [
            "title" => "Sie sind dabei, pixelated zu löschen",
            "description" =>
                "Durch das Löschen Ihrer Bewerbung werden alle Ihre Informationen aus unserer Datenbank entfernt.",
        ],
        "messages" => [
            "created_successfully_title" =>
                "Die Rolle wurde erfolgreich erstellt",
            "created_successfully_body" =>
                "Die Rolle wurde erfolgreich erstellt",
            "created_error_title" => "Fehler beim Erstellen der Rolle",
            "created_error_body" =>
                "Beim Erstellen der Rolle ist ein Fehler aufgetreten",
            "updated_successfully_title" =>
                "Die Rolle wurde erfolgreich geändert",
            "updated_successfully_body" =>
                "Die Rolle wurde erfolgreich geändert",
            "updated_error_title" => "Fehler beim Ändern der Rolle",
            "updated_error_body" =>
                "Beim Ändern der Rolle ist ein Fehler aufgetreten",
            "deleted_successfully_title" =>
                "Die Rolle wurde erfolgreich gelöscht",
            "deleted_successfully_message" =>
                "Die Rolle wurde erfolgreich gelöscht",
            "deleted_error_title" => "Fehler beim Löschen der Rolle",
            "deleted_error_message" =>
                "Beim Löschen der Rolle ist ein Fehler aufgetreten",
        ],
        "validations" => [
            "name_ar_required" => "Rollenname auf Arabisch ist erforderlich",
            "name_ar_string" =>
                "Der arabische Rollenname muss vom Typ Zeichenfolge sein",
            "name_ar_min" =>
                "Die Mindestanzahl von Buchstaben im arabischen Namen Dur beträgt mindestens 3 Buchstaben",
            "name_en_required" => "Rollenname in Englisch ist erforderlich",
            "name_en_string" =>
                "Der englische Rollenname muss eine Zeichenfolge sein",
            "name_en_min" =>
                "Die Mindestanzahl von Buchstaben im englischen Rollennamen beträgt mindestens 3 Buchstaben",
            "scope_required" => "Domäne ist erforderlich",
            "permissions_required" =>
                "Mindestens eine Genehmigung muss ausgewählt werden",
            "permissions_array" =>
                "Der Berechtigungsfeldtyp muss ein Array sein",
            "permissions_present" =>
                "Genehmigungen müssen mindestens eine enthalten",
        ],
    ],
    "certificates" => "Referenzen",
    "certificate_title" => "Zertifikatname",
    "certificate_image" => "Zertifikatskopie",
    "certificate_requests" => "Zertifizierungsanfragen",
    "certificate_edit" => "Ändern Sie das Zertifikat",
    "certificate_please_enter_title" =>
        "Bitte geben Sie den Titel des Zertifikats ein",
    "certificate_please_enter_image" =>
        "Bitte geben Sie eine Kopie des Zertifikats ein",
    "certificate_download" => "Laden Sie das Zertifikat herunter",
    "certificate_request_vendor" => "Händler",
    "certificate_request_file" => "Zertifikatsdatei",
    "certificate_request_expire" => "Ablaufdatum des Zertifikats",
    "certificate_approve" => "Das Zertifikat wurde genehmigt",
    "certificate_reject" => "Das Zertifikat wurde abgelehnt",
    "certificates_number" => "Die Anzahl der Zertifikate",
    "no_certificates" => "Es gibt keine Zeugnisse",
    "certificates_create" => "Erstellen Sie ein Zertifikat",
    "certificates_edit" => "Zertifikat bearbeiten",
    "vendors_info" => [
        "vendor_name_ar" => "Der Name des Ladens ist arabisch",
        "vendor_name_en" => "Der Name des Ladens ist Englisch",
        "validations" => [
            "vendor_name_ar" => "Das arabische Namensfeld ist erforderlich",
            "commission_required" =>
                "Der Verwaltungsprozentsatz des Verkaufspreises ist erforderlich",
            "commission_gte" =>
                "Das Managementverhältnis des Verkaufspreises ist größer oder gleich 0",
            "vendor_name_en" => "Englisches Namensfeld ist erforderlich",
        ],
    ],
    "vendorWallets" => [
        "in" => "Zusatz",
        "out" => "Rivale",
        "all_wallets" => "Alle Konten",
        "vendor_name" => "Geschäftsname",
        "vendor_name_ar" => "Der Name des Ladens ist arabisch",
        "vendor_name_en" => "Der Name des Ladens ist Englisch",
        "user_vendor_name" => "Name des Ladenbesitzers",
        "show" => "ein Angebot",
        "sub_balance" => "Guthaben abziehen",
        "id" => "Konto-ID",
        "manage" => "Verwaltung des Filialportfolios",
        "import" => "Konten importieren",
        "search" => "Konten suchen",
        "title" => "Konten speichern",
        "single_title" => "Speichert Konto",
        "customer_name" => "Speichert den Namen",
        "attachments" => "Anhänge",
        "no_attachments" => "Es gibt keine Anhänge",
        "by_admin" => "von",
        "is_active" => "Aktivierungsstatus",
        "last_update" => "Letzte Aktualisierung",
        "active" => "aktiv",
        "inactive" => "nicht aktiv",
        "choose_state" => "Wählen Sie den Kontostatus",
        "choose_customer" => "Wählen Sie einen Händler aus",
        "amount" => "Gleichgewicht",
        "reason" => "der Grund",
        "created_at" => "Das Datum, an dem das Konto erstellt wurde",
        "created_at_select" => "Wählen Sie ein Datum aus",
        "all" => "alle",
        "filter" => "filtern",
        "attachemnts" => "Laden Sie den Anhang herunter",
        "no_result_found" => "keine Ergebnisse gefunden",
        "attachment" => "Anhänge",
        "has_attachment" => "Anhangsvorschau",
        "has_no_attachment" => "Es gibt keine Anhänge",
        "change_status" => "Kontostatus ändern",
        "manage_wallet_balance" => "Kontostandsverwaltung",
        "current_wallet_balance" => "aktuellen Kontostand",
        "subtract" => "Rivale",
        "wallet_balance" => "Kontostand",
        "wallets_transactions" => [
            "title" => "Kontobewegungen",
            "single_title" => "Kontotransaktion",
            "customer_name" => "Speichert den Namen",
            "wallet_id" => "Konto-ID",
            "amount" => "Der Betrag der Transaktion",
            "transaction_date" => "Transaktionsdatum",
        ],
        "messages" => [
            "created_successfully_title" => "Neues Händlerkonto",
            "created_successfully_body" =>
                "Ein neues Händlerkonto wurde erfolgreich erstellt",
            "created_error_title" =>
                "Erstellung des Händlerkontos fehlgeschlagen",
            "created_error_body" =>
                "Erstellung eines neuen Händlerkontos fehlgeschlagen",
            "updated_successfully_title" => "Status des Händlerkontos ändern",
            "updated_successfully_body" =>
                "Status des Händlerkontos erfolgreich geändert",
            "updated_error_title" =>
                "Statusänderung des Händlerkontos fehlgeschlagen",
            "updated_error_body" =>
                "Statusanpassung des Händlerkontos fehlgeschlagen",
            "customer_has_wallet_title" =>
                "Es ist nicht möglich, ein Konto für diesen Shop zu erstellen",
            "customer_has_wallet_message" =>
                "Es ist nicht möglich, ein Konto für diesen Shop zu erstellen, da er bereits eines hat",
        ],
        "customer_info" => [
            "email" => "Post",
            "phone" => "Handy",
        ],
        "transaction" => [
            "title" => "Kontostandsverwaltung",
            "wallet_transactions_log" => "Transaktionshistorie des Kontos",
            "id" => "Transaktions-ID",
            "type" => "Art der Transaktion",
            "receipt_url" => "Betriebsstätte",
            "operation_type" => "Wählen Sie die Art der Transaktion",
            "reference" => "Ref",
            "reference_id" => "Referenznummer",
            "admin_by" => "von Administrator",
            "amount" => "Transaktionswert",
            "date" => "Transaktionsdatum",
            "add" => "Fügen Sie + hinzu",
            "sub" => "Rivale -",
            "receipt" => "Anhänge",
            "success_add_title" =>
                "Erfolgreicher Prozess zum Hinzufügen von Krediten",
            "success_add_message" =>
                "Die Händlerkarte wurde erfolgreich gutgeschrieben",
            "success_sub_title" => "Erfolgreicher Kreditabzug",
            "success_sub_message" =>
                "Das Händlerkartenguthaben wurde erfolgreich belastet",
            "fail_add_title" => "Guthaben hinzufügen fehlgeschlagen",
            "fail_add_message" => "Gutschrift der Händlerkarte fehlgeschlagen",
            "fail_sub_title" => "Guthabenabzug fehlgeschlagen",
            "fail_sub_message" =>
                "Die Belastung der Händlerkarte ist fehlgeschlagen",
            "cannot_subtract_message" =>
                "Das Kartenguthaben ist kleiner als die Rabattwerte",
            "user_id" => "Der Prozess wurde von durchgeführt",
            "order_code" => "Anfrage Code",
            "transaction_type" => [
                "title" => "Operationstyp",
                "choose_transaction_type" => "Wählen Sie die Art der Operation",
                "purchase" => "Produkte kaufen",
                "gift" => "Geschenk",
                "bank_transfer" => "Banküberweisung",
                "compensation" => "Entschädigung",
            ],
            "opening_balance" => "Anfangsbestand",
            "validations" => [
                "amount_required" =>
                    "Das Transaktionswertfeld ist erforderlich",
                "amount_numeric" =>
                    "Der Transaktionswert muss ein numerischer Wert sein",
                "receipt_url_required" =>
                    "Das Feld Transaktionstyp ist erforderlich",
                "receipt_url_image" =>
                    "Sie müssen die Art der Transaktion auswählen",
            ],
        ],
        "vendors_finances" => "Finanzen speichern",
    ],
    "select-option" => "Wählen",
    "settings" => [
        "main" => "Einstellungen",
        "show" => "ein Angebot",
        "id" => "AUSWEIS",
        "key" => "der Name",
        "value" => "der Wert",
        "manage_settings" => "Einstellungsverwaltung",
        "edit" => "Änderung",
        "validations" => [
            "pdf" => "Die Datei muss ein PDF sein",
        ],
        "messages" => [
            "setting-not-editable" =>
                "Diese Einstellung kann nicht geändert werden",
            "updated_successfully_title" => "Ändern Sie den Wert",
            "updated_error_title" => "Wertänderung fehlgeschlagen",
            "updated_successfully_body" =>
                "Der Wert wurde erfolgreich geändert",
            "updated_error_body" =>
                "Die Wertänderungsoperation ist fehlgeschlagen",
        ],
    ],
    "coupons" => [
        'title'=>'Titel',
        "id" => "Auftragsnummer",
        "manage_coupons" => "Gutscheinverwaltung",
        "pending" => "Ich warte",
        "approved" => "Ermöglicht",
        "rejected" => "Behinderte",
        "messages" => [
            "created_successfully_title" =>
                "Ein neuer Gutschein wurde erstellt",
            "created_successfully_body" => "Ein neuer Gutschein wurde erstellt",
            "created_error_title" =>
                "Erstellung eines neuen Gutscheins fehlgeschlagen",
            "created_error_body" =>
                "Erstellung eines neuen Gutscheins fehlgeschlagen",
            "updated_successfully_title" => "Coupon-Änderung",
            "updated_successfully_body" =>
                "Der Gutschein wurde erfolgreich geändert",
            "updated_error_title" =>
                "Coupon-Änderung erfolgreich fehlgeschlagen",
            "updated_error_body" => "Coupon-Änderung fehlgeschlagen",
            "deleted_successfully_title" =>
                "Gutschein wurde erfolgreich entfernt",
            "deleted_successfully_message" =>
                "Gutschein wurde erfolgreich entfernt",
            "deleted_error_title" => "Fehler beim Löschen des Gutscheins",
            "deleted_error_message" =>
                "Beim Löschen eines Gutscheins ist ein Fehler aufgetreten",
        ],
        "coupon_type" => "Gutscheintyp",
        "coupon_types" => [
            "vendor" => "Händlerrabatte",
            "product" => "Produktrabatte",
            "global" => "Allgemeine Rabatte",
            "free" => "Gratisversand",
        ],
        "amount" => "Rabattwert",
        "minimum_order_amount" => "Mindestbestellmenge",
        "maximum_discount_amount" => "Der maximale Rabatt",
        "code" => "Code",
        "maximum_redemptions_per_user" => "Die Anzahl der Kundennutzung",
        "maximum_redemptions_per_coupon" =>
            "Die Anzahl der Einlösung für den Coupon",
        "title_ar" => "Die Adresse ist arabisch",
        "title_en" => "Die Adresse ist englisch",
        "filter" => "suchen",
        "not_found" => "Es gibt keine Gutscheine",
        "create" => "Gutschein hinzufügen",
        "update" => "Coupon-Anpassung",
        "search" => "Forschung",
        "choose_state" => "Status auswählen",
        "status" => "die Bedingung",
        "percentage" => "Rate",
        "fixed" => "Menge",
        "discount_type" => "Rabatttyp",
        "validations" => [
            "title_ar_required" => "Adresse muss eingegeben werden",
            "title_en_required" => "Sie müssen den englischen Titel eingeben",
            "title_en_max" => "größer als angegeben",
            "title_en_min" => "kleiner als angegeben",
            "code_required" => "Der Code muss eingegeben werden",
            "code_unique" => "Der Code wird bereits verwendet",
            "code_min" =>
                "Die zulässige Mindestanzahl an Zeichen beträgt 4 Zeichen",
            "amount_required" => "Die angegebene Menge muss eingegeben werden",
            "amount_numeric" => "Der Mengenwert muss ein numerischer Wert sein",
            "amount_min" => "kleiner als angegeben",
            "minimum_amount_required" =>
                "Sie müssen einen Mindestbestellwert eingeben",
            "minimum_amount_min" => "kleiner als angegeben",
            "minimum_amount_max" => "größer als angegeben",
            "minimum_amount_lt" =>
                "Das Minimum muss kleiner als das Maximum sein",
            "amount_percentage" =>
                "Es hat den bekannten Prozentsatz überschritten und ist 100 %",
            "amount_fixed" => "Sie haben den Betrag überschritten",
            "coupon_type_required" => "Gutscheintyp ist erforderlich",
            "vendors_required" =>
                "Es muss mindestens ein Händler ausgewählt werden",
            "products_required" =>
                "Es muss mindestens ein Produkt ausgewählt werden",
            "status_required" => "Gutscheinstatus eingeben",
            "maximum_amount_required" =>
                "Sie müssen einen maximalen Rabatt eingeben",
            "maximum_amount_min" => "kleiner als angegeben",
            "maximum_amount_max" => "größer als angegeben",
            "maximum_amount_gt" =>
                "Das Maximum muss größer als das Minimum sein",
            "discount_type_required" => "Sie müssen die Rabattart eingeben",
            "maximum_redemptions_per_coupon_integer" =>
                "Es muss eine gültige Nummer sein",
            "maximum_redemptions_per_user_integer" =>
                "Es muss eine gültige Nummer sein",
            "maximum_redemptions_per_coupon_max" => "größer als angegeben",
            "maximum_redemptions_per_coupon_min" => "weniger als angegeben",
            "maximum_redemptions_per_user_max" => "größer als angegeben",
            "maximum_redemptions_per_user_min" => "weniger als angegeben",
            "start_at_date" => "Bitte geben Sie den Wert als Datum ein",
            "start_at_before" => "Das Startdatum muss vor dem Enddatum liegen",
            "expire_at_date" => "Bitte geben Sie den Wert als Datum ein",
            "expire_at_after" => "Das Enddatum muss nach dem Startdatum liegen",
        ],
        "filter_status" => "Filterstatus",
        "show" => "Gutscheindetails",
        "list" => "Zurück für alle Coupons",
        "delete" => "Gutschein scannen",
        "delete_modal" => [
            "title" => "Möchten Sie den Coupon scannen?",
            "description" => "Der Gutschein wird gelöscht",
        ],
        "start_at" => "Anfangsdatum",
        "expire_at" => "Verfallsdatum",
        "edit" => "Änderung",
    ],
    "cant-delete-related-to-product" =>
        "Daten können nicht gelöscht werden, da sie in Produkten verwendet werden",
    "permission_vendor_users" => "Läden verwenden",
    "permission_vendor_roles" => "Benutzerrollen speichern",
    "permission_vendor_roles_create" => "Store-Benutzerrollen hinzufügen",
    "permission_vendor_roles_edit" =>
        "Ändern Sie die Rollen der Store-Benutzer",
    "permission_vendor_role_name" => "der Name",
    "permission_vendor_role_name_please" =>
        "Bitte geben Sie den Autorisierungsnamen ein",
    "permission_vendor_role_permissions" => "Kräfte",
    "permission_vendor_role_permissions_please" =>
        "Bitte wählen Sie mindestens eine Gültigkeit aus",
    "vendor_users" => "Läden verwenden",
    "vendor_users_create" => "Fügen Sie einen Benutzer zum Geschäft hinzu",
    "vendor_users_edit" => "Ändern Sie einen Store-Benutzer",
    "vendor_user_name" => "Nutzername",
    "vendor_user_email" => "E-Mail des Benutzers",
    "vendor_user_phone" => "Benutzer mobil",
    "vendor_user_password" => "Benutzer-Passwort",
    "vendor_user_password_confirm" => "Bestätigen Sie das Benutzerkennwort",
    "vendor_user_role" => "Benutzer-Rolle",
    "vendor_user_vendor" => "Der Shop des Benutzers",
    "vendor_user_unblocked" => "Die Sperre wurde vom Benutzer aufgehoben",
    "vendor_user_blocked" => "Der Benutzer wurde gesperrt",
    "warehouses" => [
        "name" => "Repository-Name",
        "title" => "Lagerverwaltung",
        "single_title" => "Lagerhaus",
        "manage_warehouses" => "Lagerverwaltung",
        "yes" => "Ja",
        "no" => "NEIN",
        "id" => "Lager-ID",
        "name_ar" => "Der Name des Lagers auf Arabisch",
        "name_en" => "Der Name des Lagers in englischer Sprache",
        "torod_warehouse_name" => "Der Name des Lagers beim Paketunternehmen",
        "integration_key" => "Schlüsselverbindung mit Paketunternehmen",
        "administrator_name" =>
            "Der Name der für das Lager verantwortlichen Person",
        "administrator_phone" => "Das Telefon des Lagerverantwortlichen",
        "administrator_email" => "Mail verantwortlich für das Lager",
        "map_url" => "Kartenlink",
        "latitude" => "Breite",
        "longitude" => "Längengrad",
        "create" => "Erstellen Sie ein neues Lager",
        "edit" => "Repository-Änderung",
        "update" => "Repository-Änderung",
        "search" => "Forschung",
        "all" => "alle",
        "filter" => "filtern",
        "not_found" => "Nichts",
        "map" => "Lagerstandort",
        "show" => "Lagerdaten anzeigen",
        "delete" => "löschen",
        "reset" => "Betreff",
        "delete_modal" => [
            "title" => "Sie sind dabei, ein Repository zu löschen",
            "description" =>
                "Durch das Löschen Ihrer Bewerbung werden alle Ihre Informationen aus unserer Datenbank entfernt.",
        ],
        "messages" => [
            "created_successfully_title" => "Repository erfolgreich erstellt",
            "created_successfully_body" => "Repository erfolgreich erstellt",
            "created_error_title" => "Fehler beim Erstellen des Repositorys",
            "created_error_body" =>
                "Beim Erstellen eines Repositorys ist ein Fehler aufgetreten",
            "updated_successfully_title" =>
                "Das Repository wurde erfolgreich geändert",
            "updated_successfully_body" =>
                "Das Repository wurde erfolgreich geändert",
            "updated_error_title" => "Fehler beim Ändern des Repositorys",
            "updated_error_body" =>
                "Beim Ändern eines Repositorys ist ein Fehler aufgetreten",
            "deleted_successfully_title" =>
                "Das Repository wurde erfolgreich gelöscht",
            "deleted_successfully_message" =>
                "Das Repository wurde erfolgreich gelöscht",
            "deleted_error_title" => "Fehler beim Löschen eines Repositorys",
            "deleted_error_message" =>
                "Beim Löschen eines Repositorys ist ein Fehler aufgetreten",
        ],
        "validations" => [
            "name_ar_required" =>
                "Der Name des Lagers auf Arabisch ist erforderlich",
            "name_ar_string" =>
                "Der Feldtyp des arabischen Repository-Namens muss eine Zeichenfolge sein",
            "name_ar_min" =>
                "Die Mindestanzahl von Buchstaben für den Namen des Lagers auf Arabisch beträgt drei Buchstaben",
            "name_en_required" => "Lagername in Englisch ist erforderlich",
            "name_en_string" =>
                "Der Feldtyp für den Repository-Namen in Englisch muss eine Zeichenfolge sein",
            "name_en_min" =>
                "Die Mindestanzahl von Buchstaben für den Lagernamen in Englisch beträgt drei Buchstaben",
            "torod_warehouse_name_string" =>
                "Der Feldtyp für den Lagernamen des Paketunternehmens muss eine Zeichenfolge sein",
            "integration_key_required" =>
                "Verbindungsschlüssel mit Paketdienst erforderlich",
            "integration_key_unique" =>
                "Der Schlüssel zur Anbindung an ein Paketunternehmen existiert bereits",
            "administrator_name_required" =>
                "Der Name der für das Lager verantwortlichen Person ist erforderlich",
            "administrator_phone_required" =>
                "Benötigt wird die Telefonnummer des Lagerverantwortlichen",
            "administrator_email_required" =>
                "Die E-Mail-Adresse des Lagerverantwortlichen ist erforderlich",
            "map_url_required" => "Kartenlink erforderlich",
            "map_url_url" => "Der Kartenlink muss ein Weblink sein",
            "latitude_required" =>
                "Sie müssen einen Standort für das Lager auswählen",
            "longitude_required" =>
                "Standort für das Lager muss ausgewählt werden",
        ],
        "additional_unit_price" => "Inkrementeller Verpackungspreis",
        "package_covered_quantity" => "Die Verpackung umfasst mehrere Teile",
        "package_price" => "Verpackungspreis",
        "countries" => "Lagerländer",
        "empty-countries" =>
            "Es ist nicht möglich, ein Lager hinzuzufügen, da alle Länder im System bereits mit Lagern verknüpft wurden",
        'api-key' => 'API Key',
    ],
    "delivery" => [
        "title" => "Versand",
        "delete-modal-title" => "Bestätigen Sie das Löschen",
        "domestic-zones" => [
            'name' => 'Regionsname',
            "title" => "Liefergebiete",
            "show-title" => "Liefergebiete anzeigen",
            "create-title" => "Liefergebiet hinzufügen",
            "edit-title" => "Liefergebiet anpassen",
            "no-zones" => "Es gibt keine Liefergebiete",
            "create" => "Fügen Sie ein Liefergebiet hinzu",
            "id" => "Nummer des Liefergebiets",
            "name-ar" => "Der Name der Region ist arabisch",
            "name-en" => "Der Name der Region ist englisch",
            "cities-count" => "Anzahl der Städte",
            "delete-body" => "Sind Sie sicher, dass Sie die Lieferzone:zone",
            "cities" => "Städte des Liefergebiets",
            "deliver-fees" => "Versandkosten (SAR)",
            "delivery-type" => "Lieferart",
            "countries" => "Länder",
            "delivery_fees" => "Zustellgebühr",
            "delivery_fees_covered_kilos" =>
                "Die Versandkosten decken die Anzahl der Kilo ab",
            "additional_kilo_price" => "Extra-Kilo-Preis",
            "messages" => [
                "success-title" => "Operation erfolgreich abgeschlossen",
                "deleted" => "Das Liefergebiet wurde erfolgreich gelöscht",
                "created" => "Liefergebiet wurde erfolgreich hinzugefügt",
                "updated" => "Das Liefergebiet wurde erfolgreich geändert",
                "warning-title" =>
                    "Die Operation konnte nicht abgeschlossen werden",
                "no-countries" =>
                    "Alle Länder wurden zuvor an Lieferzonen angeschlossen",
                "select-country" => "Bitte wählen Sie ein gültiges Land aus",
            ],
            "delivery-feeses" => [
                "title" => "Versandkosten nach Gewicht",
                "weight-from" => "Gewicht ab",
                "weight-to" => "Gewicht für mich",
                "delivery-fees" => "Versandkosten",
                "download-desc" =>
                    "Die Preise können kontrolliert werden, indem eine CSV-Datei mit Gewicht von, Gewicht bis und Preis angehängt wird. Sie können eine Kopie der Datei herunterladen, die erste Zeile löschen und dann Ihre Daten einfügen",
                "download-validation-desc" =>
                    "Die Felder müssen (Gewicht in Kilo akzeptiert Bruchteile) und (Gewicht in Kilo akzeptiert Bruchteile) und (Preis in Riyal akzeptiert Bruchteile) enthalten.",
                "download-rows-desc" =>
                    "Es werden nur die ersten 500 Zeilen aufgenommen, und falls es eine Zeile gibt, die nicht mit den Bedingungen übereinstimmt, wird die Datei als Ganzes ignoriert",
                "download" => "Laden Sie eine Kopie des Preises herunter",
                "upload" => "Datei-Upload",
                "delivery_fees_sheet" => "Preisdatei",
                "sheet-uploaded" =>
                    "Die Preisdatei wurde heruntergeladen und in der Datenbank aktualisiert",
            ],
        ],
    ],
    "torodCompanies" => [
        "title" => "Management von Paketversandunternehmen",
        "single_title" => "Versandunternehmen",
        "manage_torodCompanies" => "Management von Paketversandunternehmen",
        "yes" => "Ja",
        "no" => "NEIN",
        "id" => "Firmen-ID",
        "name_ar" => "Firmenname auf Arabisch",
        "name_en" => "Firmenname auf Englisch",
        "desc_ar" => "Firmenbeschreibung auf Arabisch",
        "desc_en" => "Firmenbeschreibung in Englisch",
        "active_status" => "Unternehmensstatus",
        "delivery_fees" => "Versandkosten",
        "domestic_zone_id" => "Kennung des Liefergebiets",
        "domestic_zone" => "Lieferzone",
        "torod_courier_id" => "Firmen-ID bei Paketen",
        "create" => "Erstellen Sie ein neues Unternehmen",
        "edit" => "Firmenänderung",
        "update" => "Firmenänderung",
        "search" => "Forschung",
        "all" => "alle",
        "filter" => "filtern",
        "not_found" => "Nichts",
        "map" => "Die Website des Unternehmens",
        "show" => "Firmendaten einsehen",
        "delete" => "löschen",
        "active" => "aktiv",
        "inactive" => "nicht aktiv",
        "choose_state" => "Unternehmensstatus auswählen",
        "choose_domistic_zone" => "Wählen Sie das Liefergebiet",
        "logo" => "Firmenlogo",
        "delete_modal" => [
            "title" => "Sie sind dabei, ein Unternehmen zu löschen",
            "description" =>
                "Durch das Löschen Ihrer Bewerbung werden alle Ihre Informationen aus unserer Datenbank entfernt.",
        ],
        "messages" => [
            "created_successfully_title" => "Unternehmen erfolgreich gegründet",
            "created_successfully_body" => "Unternehmen erfolgreich gegründet",
            "created_error_title" =>
                "Fehler bei der Erstellung des Unternehmens",
            "created_error_body" =>
                "Beim Erstellen eines Unternehmens ist etwas schief gelaufen",
            "updated_successfully_title" => "Firma wurde erfolgreich geändert",
            "updated_successfully_body" => "Firma wurde erfolgreich geändert",
            "updated_error_title" => "Fehler beim Ändern des Unternehmens",
            "updated_error_body" =>
                "Beim Bearbeiten eines Unternehmens ist ein Fehler aufgetreten",
            "deleted_successfully_title" =>
                "Unternehmen wurde erfolgreich gelöscht",
            "deleted_successfully_message" =>
                "Unternehmen wurde erfolgreich gelöscht",
            "deleted_error_title" => "Fehler beim Löschen eines Unternehmens",
            "deleted_error_message" =>
                "Beim Löschen eines Unternehmens ist ein Fehler aufgetreten",
        ],
        "validations" => [
            "name_ar_required" => "Firmenname auf Arabisch ist erforderlich",
            "name_ar_string" =>
                "Der Feldtyp des arabischen Firmennamens muss eine Zeichenfolge sein",
            "name_ar_min" =>
                "Die Mindestanzahl von Buchstaben für den Firmennamen auf Arabisch beträgt drei Buchstaben",
            "name_en_required" => "Firmenname in Englisch ist erforderlich",
            "name_en_string" =>
                "Der Feldtyp Englischer Firmenname muss eine Zeichenfolge sein",
            "name_en_min" =>
                "Die Mindestanzahl von Buchstaben für den Firmennamen in englischer Sprache beträgt drei Buchstaben",
            "desc_ar_required" =>
                "Firmenbeschreibung in Arabisch ist erforderlich",
            "desc_ar_string" =>
                "Der Feldtyp für die arabische Firmenbeschreibung muss eine Zeichenfolge sein",
            "desc_ar_min" =>
                "Die Mindestanzahl von Zeichen für das Firmenbeschreibungsfeld auf Arabisch beträgt drei Buchstaben",
            "desc_en_required" =>
                "Firmenbeschreibung in englischer Sprache erforderlich",
            "desc_en_string" =>
                "Der Feldtyp für die Unternehmensbeschreibung in Englisch muss eine Zeichenfolge sein",
            "desc_en_min" =>
                "Die Mindestanzahl von Zeichen für das Feld „Firmenbeschreibung“ in englischer Sprache beträgt drei Zeichen",
            "active_status_boolean" =>
                "Der Status des Unternehmens muss ein boolescher Wert sein",
            "delivery_fees_required" => "Versandkosten sind erforderlich",
            "delivery_fees_numeric" => "Versandwert sollte sein",
            "domestic_zone_id_required" => "Versandbereich erforderlich",
            "torod_courier_id_required" =>
                "Paketunternehmens-ID ist erforderlich",
            "torod_courier_id_unique" =>
                "Die Firmen-ID von Parcel ist bereits vorhanden",
            "logo_image" => "Das hochgeladene Logo muss ein Bildtyp sein",
            "logo_mimes" =>
                "Die zulässigen Erweiterungen für das Logo sind jpeg, png, jpg, gif, svg",
            "logo_max" => "Die maximale Größe für ein Firmenlogo beträgt 2048M",
        ],
    ],
    "integrations" => [
        "national-warehouse" => "Lokales Lager in Saudi-Arabien",
    ],
    "statistics" => [
        "admin" => [
            "total_customers" => "Anzahl der Kunden",
            "total_orders" => "Die Anzahl der Bestellungen",
            "total_sales" => "Gesamtumsatz",
            "total_revenues" => "Gesamteinnahmen",
            "total_vendors" => "Anzahl der Händler",
            "customer_rating_ratio" => "Kundenbewertungsrate",
            "best_selling_vendors" => "meistverkauften Händler",
            "best_selling_products" => "Meistverkaufte Produkte",
            "total_selling_categories" => "Meistverkaufte Abteilung",
            "most_requested_customers" => "Anspruchsvollste Kunden",
            "total_requests_according_to_status" =>
                "Die Anzahl der Anfragen je nach Fall",
            "total_requests_according_to_country" =>
                "Die Anzahl der Bewerbungen nach Ländern",
            "products_count" => "Gesamtprodukte",
        ],
        "vendor" => [
            "total_orders" => "Die Anzahl der Bestellungen",
            "total_sales" => "Gesamtumsatz",
            "total_revenues" => "Gesamteinnahmen",
            "best_selling_products" => "Meistverkaufte Produkte",
            "total_requests_according_to_status" =>
                "Die Anzahl der Anfragen je nach Fall",
            "total_requests_according_to_country" =>
                "Die Anzahl der Bewerbungen nach Ländern",
        ],
        "customer" => "Klient",
        "order" => "anzufordern",
        "vendors" => "Händler",
    ],
    "shipping_type" => "Versandart",
    "shippingMethods" => [
        "torod" => "Paketunternehmen",
        "bezz" => "Biz Reederei",
        "integration_key" => "verbindlicher Code",
        "choose_key" => "Wählen Sie den Linkcode",
        "choose_type" => "Wählen Sie die Versandart",
        "create" => "Reederei gründen",
        "logo" => "Foto der Reederei",
        "store" => "speichern",
        "name_ar" => "Der Name ist auf Arabisch",
        "name_en" => "englischer Name",
        "type" => "Typ",
        "cod_collect_fees" => "Kosten für die Erhebung von Hausgeld",
        "id" => "Reederei-ID",
        "manage_shippingMethods" => "Geschäftsführung von Reedereien",
        "search" => "Forschung",
        "filter" => "filtern",
        "not_found" => "Es gibt keine Reedereien",
        "index" => "Reedereien",
        ShippingMethodType::NATIONAL => "lokal",
        ShippingMethodType::INTERNATIONAL => "International",
        "show" => "Angebot der Reederei",
        "edit" => "Ändern Sie die Reederei",
        "delete" => "Löschen Sie die Reederei",
        "delete_modal" => [
            "title" => "Löschung bestätigen",
            "description" => "Möchten Sie die Reederei wirklich löschen?",
        ],
        "messages" => [
            "created_successfully_title" => "Reederei erfolgreich etabliert",
            "created_successfully_body" => "Reederei erfolgreich etabliert",
            "created_error_title" => "Fehler beim Erstellen der Reederei",
            "created_error_body" =>
                "Beim Erstellen der Reederei ist etwas schief gelaufen",
            "updated_successfully_title" =>
                "Reederei wurde erfolgreich geändert",
            "updated_successfully_body" =>
                "Reederei wurde erfolgreich geändert",
            "updated_error_title" => "Fehler beim Ändern der Reederei",
            "updated_error_body" =>
                "Beim Ändern der Reederei ist ein Fehler aufgetreten",
            "deleted_successfully_title" =>
                "Reederei wurde erfolgreich gelöscht",
            "deleted_successfully_message" =>
                "Reederei wurde erfolgreich gelöscht",
            "deleted_error_title" =>
                "Fehler beim Löschen des Versandunternehmens",
            "deleted_error_message" =>
                "Beim Löschen des Mobilfunkanbieters ist ein Fehler aufgetreten",
            "related-domestic-zones-synced" =>
                "Die Reederei wurde erfolgreich an die Liefergebiete angebunden",
        ],
        "related-domestic-zones" => "Liefergebiete der Reederei",
    ],
    "order_statuses" => [
        OrderStatus::REGISTERD => "Bauarbeiten im Gange",
        OrderStatus::PAID => "bezahlt",
        OrderStatus::SHIPPING_DONE => "Geliefert",
        OrderStatus::IN_DELEVERY => "Lieferung ist im Gange",
        OrderStatus::COMPLETED => "vollständig",
        OrderStatus::CANCELED => "abgesagt",
        "refund" => "Rückblick",
    ],
    "banks" => [
        "title" => "Banken",
        "single_title" => "die Bank",
        "all_banks" => "Alle Banken",
        "manage_banks" => "Bankmanagement",
        "id" => "Bank-ID",
        "name_ar" => "Arabischer Name",
        "name_en" => "Der Name ist auf Englisch",
        "is_active" => "die Bedingung",
        "yes" => "Ja",
        "no" => "NEIN",
        "create" => "Erstellen Sie eine neue Bank",
        "update" => "Bankanpassung",
        "search" => "Forschung",
        "all" => "alle",
        "filter" => "filtern",
        "not_found" => "Nichts",
        "show" => "Bankdaten einsehen",
        "delete" => "löschen",
        "active" => "aktiv",
        "inactive" => "nicht aktiv",
        "choose_status" => "Wählen Sie den Bundesstaat der Bank aus",
        "filter_is_active" => "Nach Status filtern",
        "delete_modal" => [
            "title" => "Sie sind dabei, eine Bank zu löschen",
            "description" =>
                "Durch das Löschen Ihrer Bewerbung werden alle Ihre Informationen aus unserer Datenbank entfernt.",
        ],
        "messages" => [
            "created_successfully_title" =>
                "Die Bank wurde erfolgreich erstellt",
            "created_successfully_body" =>
                "Die Bank wurde erfolgreich erstellt",
            "created_error_title" => "Fehler beim Erstellen der Bank",
            "created_error_body" =>
                "Beim Erstellen der Bank ist etwas schief gelaufen",
            "updated_successfully_title" =>
                "Die Bank wurde erfolgreich geändert",
            "updated_successfully_body" =>
                "Die Bank wurde erfolgreich geändert",
            "updated_error_title" => "Fehler beim Ändern der Bank",
            "updated_error_body" =>
                "Beim Ändern der Bank ist ein Fehler aufgetreten",
            "deleted_successfully_title" =>
                "Die Bank wurde erfolgreich gelöscht",
            "deleted_successfully_message" =>
                "Die Bank wurde erfolgreich gelöscht",
            "deleted_error_title" => "Fehler beim Löschen der Bank",
            "deleted_error_message" =>
                "Beim Löschen der Bank ist etwas schief gelaufen",
        ],
        "validations" => [
            "name_ar_required" => "Bankname in Arabisch ist erforderlich",
            "name_ar_string" =>
                "Der Name der arabischen Bank muss eine Zeichenfolge sein",
            "name_ar_min" =>
                "Die Mindestanzahl von Buchstaben im Namen der Arab Bank beträgt mindestens 3 Buchstaben",
            "name_en_required" =>
                "Der Name der Bank in englischer Sprache ist erforderlich",
            "name_en_string" =>
                "Der englische Bankname muss eine Zeichenfolge sein",
            "name_en_min" =>
                "Die Mindestanzahl von Buchstaben im Namen der englischen Bank beträgt mindestens 3 Buchstaben",
        ],
    ],
    "general_settings" => "Allgemeine Einstellungen",
    "warning" => "Warnung",
    "action-disabled" => "Diese Aktion ist derzeit deaktiviert",
    "is_visible" => "die Bedingung",
    "bezz" => "Bienen Corporation",
    "tracking_id" => "Sendungsverfolgungs-ID",
    "no_shipment" => "Noch nicht versandt",
    "shipping_info" => "Versanddaten",
    "track_shipment" => "Sendungsverfolgung",
    "beez_id" => "Biz Store-ID",
    "beez_id_unique" => "Die Biz Store-ID ist bereits vorhanden",
    "paid" => "bezahlt",
    "update" => "aktualisieren",
    "delete" => "löschen",
    "shipping_type_placeholder" => "Wählen Sie die Art der Verbindung",
    "shipping_countries_placeholder" => "Land auswählen",
    "country_assossiated_to_domestic_zone" =>
        "Das Land ist bereits mit einem Liefergebiet verknüpft",
    "national" => "lokal",
    "international" => "International",
    "country" => "Land",
    "country_placeholder" => "Land auswählen",
    "countries_prices" => [
        "id" => "Bank-ID",
        "title" => "Produktpreis je nach Land",
        "country" => "Land",
        "price" => "englischer Name",
        "price_before" => "die Bedingung",
        "add_edit_alert" =>
            "Es ist erlaubt, den Preis des Produkts für jedes Land zu ändern oder hinzuzufügen, falls dieses Produkt geändert wird",
        "list" => "Zeigen Sie die Produktpreise nach Ländern an",
        "delete_modal" => [
            "title" => "Sie sind dabei, einen Länderpreis zu löschen",
            "description" =>
                "Durch das Löschen Ihrer Bewerbung werden alle Ihre Informationen aus unserer Datenbank entfernt.",
        ],
        "messages" => [
            "created_successfully_title" =>
                "Der Bundestarif wurde erfolgreich erstellt",
            "created_successfully_body" =>
                "Der Bundestarif wurde erfolgreich erstellt",
            "created_error_title" => "Fehler beim Erstellen des Statuspreises",
            "created_error_body" =>
                "Beim Erstellen des Länderpreises ist ein Fehler aufgetreten",
            "updated_successfully_title" =>
                "Der Zustandspreis wurde erfolgreich geändert",
            "updated_successfully_body" =>
                "Der Zustandspreis wurde erfolgreich geändert",
            "updated_error_title" => "Fehler beim Anpassen des Länderpreises",
            "updated_error_body" =>
                "Beim Anpassen des Länderpreises ist ein Fehler aufgetreten",
            "deleted_successfully_title" =>
                "Länderpreis wurde erfolgreich gelöscht",
            "deleted_successfully_message" =>
                "Länderpreis wurde erfolgreich gelöscht",
            "deleted_error_title" => "Fehler beim Löschen des Länderpreises",
            "deleted_error_message" =>
                "Beim Löschen des Länderpreises ist ein Fehler aufgetreten",
        ],
        "validations" => [
            "country_id_required" => "Zustand erforderlich",
            "price_with_vat_required" =>
                "Sie müssen den Preis mit Mehrwertsteuer eingeben",
            "price_before_required" =>
                "Der Preis muss vor dem Rabatt eingegeben werden",
            "price_min" => "Der niedrigste Preis sollte 1 sein",
            "price_before_offer_min" => "Der niedrigste Preis sollte 1 sein",
            "price_max" => "Der Höchstpreis sollte 1.000.000 betragen",
            "price_before_offer_max" =>
                "Der Höchstpreis sollte 1.000.000 betragen",
        ],
    ],
    "transaction_sent_to_bezz_before" => "Diese Anfrage wurde zuvor an Biz gesendet",
    "transaction_sent_to_bezz" => "Die Anfrage wurde an Biz gesendet",
    "transaction-send-to-bezz" => "Senden Sie die Anfrage an Biz",
    "transaction_warnings" => "Warnungen für die Bestellung",
    "stock-decrement-errors" => "Eine falsche Veranstaltung bei der Aktualisierung der Mengen mit Produkten",
    "stock-country-missed" => "Es gibt keine Lagerung für ein Land: Land in Ordnung Nr.: Transaktion",
    "stock-warehouse-missed" => "Es gibt kein Lagerhaus: Warehouse ist dem Produkt gewidmet: Produkt",
    "stock-increment-errors" => "Bei der Rückgabe der Produktmengen trat ein Fehler auf",
    "transaction-missed-shipping-method" => "Reversendweiterungsgesellschaft existiert keine Bestellnummer: Transaktion",
    "reports" => [
        "title" => "Berichte",
        "select-vendor" => "Wählen Sie ein Geschäft",
        "date-from" => "Geschichte von",
        "date-to" => "Geschichte für mich",
        "print" => "Drucken Sie den Bericht",
        "excel" => "Expelexportexport",
        "vendors-orders" => [
            "title" => "Geschäft erfordert",
            "vendor" => "Das Geschäft",
            "order-code" => "Anfrage Code",
            "order-id" => "Bestellnummer",
            "created-at" => "Konstruktionsdatum des Antrags",
            "delivered-at" => "Datum der Lieferung des Antrags",
            "total-without-vat" => "Gesamtanfrage mit Mehrwertsteuer",
            "vat-rate" => "Steuerwert",
            "total-with-vat" => "Gesamtanfrage mit Mehrwertsteuer",
            "company-profit-without-vat" => "Plattformkommission mit Mehrwertsteuer",
            "company-profit-vat-rate" => "Der Wert der Plattform -Kommissionssteuer",
            "company-profit-with-vat" => "Plattformkommission mit Mehrwertsteuer",
            "vendor-amount" => "Händlergebühren",
            "no-orders" => "Bitte ändern Sie die Suchdaten",
            "sum-total-without-vat" => "Gesamtumsatz mit Mehrwertsteuer",
            "sum-vat-rate" => "Steuerwert",
            "sum-total-with-vat" => "Gesamtumsatz mit Mehrwertsteuer",
            "sum-company-profit-without-vat" => "Plattformkommission mit Mehrwertsteuer",
            "sum-company-profit-vat-rate" => "Der Wert der Plattform -Kommissionssteuer",
            "sum-company-profit-with-vat" => "Plattformkommission mit Mehrwertsteuer",
            "sum-vendor-amount" => "Gesamthändlergebühren",
            "print-vendor" => "Händlerverkaufsbericht erhalten erhalten",
            "tax-num" => "Steuernummer: Num",
            "date" => "Am Datum",
        ],
        "center-name" => "المركز الوطني للنخيل و التمور",
        "center-tax-num" => "الرقم الضريبي: 310876568300003",
    ],
    "date-range-invalid" => "يرجي إختيار (التاريخ إلي) أكبر من (التاريخ من)",
];
