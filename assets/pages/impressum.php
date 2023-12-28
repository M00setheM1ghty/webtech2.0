<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include(dirname(__DIR__) . '/components/head.php'); ?>
</head>

<body>
    <?php include(dirname(__DIR__) . '/components/nav.php'); ?>
    <main>
        <div class="container">
            <div class="impressum-div">
                <div class="p-5 mb-4 bg-body-tertiary rounded-3">
                    <div class="container-fluid py-5">
                        <h1 class="display-5 fw-bold">Impressum</h1>
                        <p class="col-md-8 fs-4">Hämmerle und Söhne GmbH</p>
                    </div>
                </div>

                <p class="col-md-8 fs-4">Kontaktdaten</p>
                <ul>
                    <li>Firmensitz: 6764 Lech am Arlberg</li>
                    <li>Zug 5 | Austria</li>
                    <li>Tel: +431234567889</li>
                    <li>E-Mail: office@hnshotel.at</li>
                </ul>

                <p class="col-md-8 fs-4">Für den Inhalt verantwortlich</p>
                <ul>
                    <li>Gesellschaft mit beschränkter Haftung</li>
                    <li>Hotel</li>
                    <li>UID-Nr: ATU12345678</li>
                    <li>FN: 123456a</li>
                    <li>FB-Gericht: Feldkirch</li>
                    <li>Mitglied der WK&Ouml;, Wirtschaftkammer Vorarlberg</li>
                    <li>Berufsrecht: ?<br>
                        <a href="www.ris.bka.gv.at" target="_blank" rel="noopener"
                            aria-label="brings you to the WKÖ homepage">Gewerbeordnung: </a>
                    </li>
                    <li>Aufsichtsbehörde: Bezirkshauptmannschaft Bludenz</li>
                    <li>Meisterbetrieb</li>
                    <li>Meisterprüfung abgelegt in &Ouml;sterreich</li>
                    <li>Angaben zur Online-Streitbelegung:
                        Verbraucher haben die Möglichkeit,
                        Beschwerden an die OnlineStreitbeilegungsplattform der EU zu
                        richten:
                        <a href="http://ec.europa.eu/odr" rel="noopener" target="_blank"
                            aria-label="brings you to the european comission webite">http://ec.europa.eu/odr</a><br>
                        Sie können allfällige Beschwerde auch an
                        die oben angegebene E-Mail-Adresse
                        richten.
                    </li>
                </ul>

                <p class="col-md-8 fs-4">Hotelverwaltung:</p>
                <p>Baumann Thomas, Markus H&auml;mmerle</p>
                <img src="../images/ThomasB.png" alt="Thomas Baumann">
                <img src="../images/MarkusH.png" alt="Markus Hämmerle">
            </div>

            <?php include(dirname(__DIR__) . '/components/footer.php'); ?>

        </div>

    </main>
</body>

</html>