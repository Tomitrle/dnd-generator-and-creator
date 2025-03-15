<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Encounter Generator</title>
    <meta name="author" content="Tommy Le">
    <meta name="description" content="Generate encounters for Dungeons & Dragons.">
    <meta name="keywords" content="dungeons and dragons, d&d, dnd, encounter, generator">

    <meta property="og:title" content="Encounter Generator">
    <meta property="og:description" content="Generate encounters for Dungeons & Dragons.">
    <meta property="og:type" content="website">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="styles/main.less" rel="stylesheet/less" type="text/css">
    <link href="styles/encounter-generator.less" rel="stylesheet/less" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/less"></script>
    <!-- Source: https://stackoverflow.com/questions/16712941/display-div-if-a-specific-select-option-value-is-selected -->
    <script>function customSizeCheck(nameSelect)
    {
        console.log(nameSelect);
        if(nameSelect){
            customOptionValue = document.getElementById("customSize").value;
            if(customOptionValue === nameSelect.value){
                document.getElementById("customSizeDiv").style.display = "block";
            }
            else{
                document.getElementById("customSizeDiv").style.display = "none";
            }
        }
        else{
            document.getElementById("customSizeDiv").style.display = "none";
        }
    }
    </script>
    <script>function customDiffCheck(nameSelect)
    {
        console.log(nameSelect);
        if(nameSelect){
            customOptionValue = document.getElementById("customDiff").value;
            if(customOptionValue === nameSelect.value){
                document.getElementById("customDiffDiv").style.display = "block";
            }
            else{
                document.getElementById("customDiffDiv").style.display = "none";
            }
        }
        else{
            document.getElementById("customDiffDiv").style.display = "none";
        }
    }
    </script>
</head>

<body>
<!-- TODO: Update link hrefs -->
<!-- https://getbootstrap.com/docs/5.3/components/navbar/-->
<nav class="navbar navbar-expand-sm">
    <div class="container-fluid">

        <a class="navbar-brand" href=".">Home</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav container-fluid">
                <a class="nav-link" href="encounter-generator.php">+ Encounter</a>
                <a class="nav-link" href="monster-editor.php">+ Monster</a>

                <a class="nav-link ms-auto" href="#">About</a>
                <a class="nav-link" href="account.php">Account</a>
            </div>
        </div>
    </div>
</nav>

<button type="button" aria-label="Previous" class="btn btn-back" onclick="history.back()">&#129120;</button>


<header class="container text-center">
    <h1>Encounter Generator</h1>
    <hr>
</header>

<!-- Source: https://getbootstrap.com/docs/5.3/forms/overview/ -->
<!-- Source: https://getbootstrap.com/docs/5.0/forms/validation/ -->
<form class="container needs-validation" novalidate>
    <section class="row">
        <h2>Party Information</h2>
        <p>Please select the number of player characters and the level of the player characters below. These values will be used when calculating the relative difficulty of the generated encounter, which is selected in the next section.</p>

        <!-- Source: https://stackoverflow.com/questions/3518002/how-can-i-set-the-default-value-for-an-html-select-element -->
        <!-- Source: https://stackoverflow.com/questions/13766015/is-it-possible-to-configure-a-required-field-to-ignore-white-space -->
        <div class="col-sm-12 mb-2">
            <label for="partySize" class="form-label">Party Size</label>
            <select id="partySize" class="form-select" aria-required="true" onchange="customSizeCheck(this);" required>
                <option selected disabled hidden value="">Select an option...</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option id="customSize" value="11">Custom</option>
            </select>
        </div>

        <div id="customSizeDiv" class="col-sm-12 mb-2" style="display: none;">
            <label for="customPartySize" class="form-label">Custom Size</label>
            <input type="text" pattern="^[1-9][0-9]*" class="form-control" id="customPartySize" aria-required="true" required>
        </div>

        <div class="col-sm-12 mb-2">
            <label for="partyLevel" class="form-label">Party Level</label>
            <select id="partyLevel" class="form-select" aria-required="true" required>
                <option selected disabled hidden value="">Select an option...</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
                <option>9</option>
                <option>10</option>
                <option>11</option>
                <option>12</option>
                <option>13</option>
                <option>14</option>
                <option>15</option>
                <option>16</option>
                <option>17</option>
                <option>18</option>
                <option>19</option>
                <option>20</option>
            </select>
        </div>
    </section>
    <hr>

    <section class="row">
        <h2>Encounter Information</h2>

        <div class="col-sm-12 mb-2">
            <p>From <a href="https://www.dndbeyond.com/sources/dnd/basic-rules-2014/building-combat-encounters">D&D Beyond's Basic Rules (2014), Chapter 13: Building Combat Encounters</a>:<br>
                <!-- https://stackoverflow.com/questions/4530957/html-code-to-indent-without-using-blockquote-so-there-is-no-space-on-the-next-l -->
                <span style="padding-left: 20px; display:block">
                There are four categories of encounter difficulty.<br>
                    <strong style="font-style: italic">Easy</strong>. An easy encounter doesn’t tax the characters’ resources or put them in serious peril. They might lose a few hit points, but victory is pretty much guaranteed.<br>

                    <strong style="font-style: italic">Medium</strong>. A medium encounter usually has one or two scary moments for the players, but the characters should emerge victorious with no casualties. One or more of them might need to use healing resources.<br>

                    <strong style="font-style: italic">Hard</strong>. A hard encounter could go badly for the adventurers. Weaker characters might get taken out of the fight, and there’s a slim chance that one or more characters might die.<br>

                    <strong style="font-style: italic">Deadly</strong>. A deadly encounter could be lethal for one or more player characters. Survival often requires good tactics and quick thinking, and the party risks defeat.
                </span>
            </p>
            <p>For the purposes of random encounter generation, the difference between these difficulties is how much experience (XP) the encounter provides. Deadly is the last XP threshold and technically has no maximum, but there is (will be) a preset maximum of 500 XP past the Deadly threshold to reduce the otherwise wild variance in Deadly encounters generated. If you would like a more specific XP amount, please select the "Custom" option, particularly if you want a Deadly encounter for a lower leveled party.</p>
            <label for="difficulty" class="form-label">Relative Difficulty</label>
            <select id="difficulty" class="form-select" aria-required="true" onchange="customDiffCheck(this);" required>
                <option selected disabled hidden value="">Select an option...</option>
                <option value="1">Easy</option>
                <option value="2">Medium</option>
                <option value="3">Hard</option>
                <option value="4">Deadly</option>
                <option value="5" id="customDiff">Custom</option>
            </select>
        </div>

        <div id="customDiffDiv" class="col-sm-12 mb-2" style="display: none;">
            <label for="customXP" class="form-label">Custom XP Amount</label>
            <input type="text" pattern="^[1-9][0-9]*" class="form-control" id="customXP" aria-required="true" required>
        </div>
    </section>
    <hr>

    <section class="row">
        <h2>Creature Information</h2>
        <p>If you would like to filter what creatures can be included in the generated encounter, you can choose which types and challenge ratings are allowed below. You can also manually add a creature to guarantee it will be in the generated encounter with the "Add Monster" button.</p>

        <div id="creatureTypes">
            <label>Creature Types</label>
            <!-- Source: https://stackoverflow.com/questions/42108219/display-checkboxes-in-two-columns-with-bootstrap -->
            <ul style="column-count: 3; column-gap: 2rem; list-style: none;">
                <li><input type="checkbox" id='aberration'><label for="aberration">Aberration</label></li>
                <li><input type="checkbox" id='beast'><label for="beast">Beast</label></li>
                <li><input type="checkbox" id='celestial'><label for="celestial">Celestial</label></li>
                <li><input type="checkbox" id='construct'><label for="construct">Construct</label></li>
                <li><input type="checkbox" id='dragon'><label for="dragon">Dragon</label></li>

                <li><input type="checkbox" id='elemental'><label for="elemental">Elemental</label></li>
                <li><input type="checkbox" id='fey'><label for="fey">Fey</label></li>
                <li><input type="checkbox" id='fiend'><label for="fiend">Fiend</label></li>
                <li><input type="checkbox" id='giant'><label for="giant">Giant</label></li>
                <li><input type="checkbox" id='humanoid'><label for="humanoid">Humanoid</label></li>

                <li><input type="checkbox" id='monstrosity'><label for="monstrosity">Monstrosity</label></li>
                <li><input type="checkbox" id='ooze'><label for="ooze">Ooze</label></li>
                <li><input type="checkbox" id='plant'><label for="plant">Plant</label></li>
                <li><input type="checkbox" id='undead'><label for="undead">Undead</label></li>
            </ul>
        </div>

        <div class="col-sm-12 mb-2">
            <label for="minCR" class="form-label">Minimum Challenge Rating</label>
            <select id="minCR" class="form-select" aria-required="true" required>
                <option selected disabled hidden value="">Select an option...</option>
                <option value="1/8">1/8</option>
                <option value="1/4">1/4</option>
                <option value="1/2">1/2</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
            </select>
        </div>

        <div class="col-sm-12 mb-2">
            <label for="maxCR" class="form-label">Maximum Challenge Rating</label>
            <select id="maxCR" class="form-select" aria-required="true" required>
                <option selected disabled hidden value="">Select an option...</option>
                <option value="1/8">1/8</option>
                <option value="1/4">1/4</option>
                <option value="1/2">1/2</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
            </select>
        </div>
    </section>
    <hr>

    <div class="d-flex justify-content-center mt-4">
        <button type="button" class="btn btn-secondary me-2" style="min-width:100px; font-size:x-large;">Add Monster</button>
        <button type="submit" class="btn btn-success ms-2" style="min-width:100px; font-size:x-large;">Generate</button>
    </div>
</form>

<!-- TODO: Update links -->
<div class="container">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <p class="col-md-4 mb-0 text-body-secondary">&copy; 2025 Brennen Muller & Tommy Le</p>

        <ul class="nav col-md-4 justify-content-end">
            <li class="nav-item"><a href="." class="nav-link px-2 text-body-secondary">Home</a></li>

            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">About</a></li>
            <li class="nav-item"><a href="account.php" class="nav-link px-2 text-body-secondary">Account</a></li>
        </ul>
    </footer>
</div>

<!-- BOOTSTRAP JAVASCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
<script src="js/encounter-generator-validator.js"></script>
</body>

</html>