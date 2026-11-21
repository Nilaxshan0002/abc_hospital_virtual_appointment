<?php
// includes/schema/cookie-policy-schema.php
$schema_data = [
    "@context" => "https://schema.org",
    "@type" => "AboutPage",
    "name" => "Cookie Policy",
    "description" => $pageDescription,
    "publisher" => [
        "@type" => "Organization",
        "name" => "ABC Virtual Healthcare",
        "logo" => [
            "@type" => "ImageObject",
            "url" => $base_url . "/images/ABC logo.webp"
        ]
    ],
    "dateModified" => "2026-02-22"
];
?>

<script type="application/ld+json">
<?php echo json_encode($schema_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
</script>