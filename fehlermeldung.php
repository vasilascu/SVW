<?php
session_start();

function setzeFehlermeldung($meldung, $typ = 'error') {
    if ($typ == 'error') {
        $_SESSION['fehlermeldung'] = $meldung;
    } elseif ($typ == 'success') {
        $_SESSION['erfolgsmeldung'] = $meldung;
    }
}

function zeigeFehlermeldung(): void
{
    if (isset($_SESSION['fehlermeldung'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                ' . $_SESSION['fehlermeldung'] . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
        unset($_SESSION['fehlermeldung']);
    }
    if (isset($_SESSION['erfolgsmeldung'])) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                ' . $_SESSION['erfolgsmeldung'] . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
        unset($_SESSION['erfolgsmeldung']);
    }
}
?>
