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
            <div class="faq-div">
                <div class="p-5 mb-4 bg-body-tertiary rounded-3">
                    <div class="container-fluid py-5">
                        <h1 class="display-5 fw-bold">FAQ</h1>
                        <p class="col-md-8 fs-4">Frage und Antwort</p>
                    </div>
                </div>
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Wo finde ich das Impressum?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Das Impressum ist hier zu finden: <a href="impressum.php">Impressum</a>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Wo kann ich mich registrieren?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Sie können sich hier registrieren: <a href="registration.php">Registrierung</a>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Wo kann ich mich einloggen?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Sie können sich hier einloggen: <a href="login.php">Login</a>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingExtra">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseExtra" aria-expanded="false" aria-controls="collapseExtra">
                                Wo kann ich eine Reservierung tätigen?
                            </button>
                        </h2>
                        <div id="collapseExtra" class="accordion-collapse collapse" aria-labelledby="headingExtra"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Hier zur Reservierung: <a href="reservierung.php">Reservierung</a>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapsFour">
                                Wo finde ich die Startseite?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Die Startseite finden sie hier: <a href="index.php">Startseite</a>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Wo ist das Hotel?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Das Hotel befindet sich hier: <a href="https://bit.ly/46jbrsl" target="_blank" rel="noopener">Maps</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include(dirname(__DIR__) . '/components/footer.php'); ?>

    </main>
</body>

</html>