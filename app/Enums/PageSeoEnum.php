<?php
namespace App\Enums;

class PageSeoEnum {
    const Home = "Home";
    const About = "About";
    const Vendors = "Vendors";
    const FAQ = "FAQ";
    const Blog = "Blog";
    const UsageAgreement = "UsageAgreement";
    const PrivacyPolicy = "PrivacyPolicy";
    const ContactUs = "ContactUs";

    public static function pages() : array {
        return [
            self::Home,
            self::About,
            self::Vendors,
            self::FAQ,
            self::Blog,
            self::UsageAgreement,
            self::PrivacyPolicy,
            self::ContactUs,
        ];
    }
}
