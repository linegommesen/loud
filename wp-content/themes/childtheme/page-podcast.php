<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>

<template>
    <article class="podcasts">
        <img class="billede" src="" alt="">
        <div>
            <h2></h2>
            <p class="beskrivelse_kort"></p>
            <p class="beskrivelse_lang"></p>
        </div>
    </article>
</template>


<main id="main" class="site-main">
    <section class="container2">
        <img src="http://linegommesen.com/kea/radio_loud/wp-content/themes/childtheme/img/podcast_banner_ny.png" alt="">
    </section>

    <nav id="filtrering">
        <div id="filterknap"><img src="http://linegommesen.com/kea/radio_loud/wp-content/themes/childtheme/img/filter.png" alt="Filter"></div>
        <ul id="menu" class="filterdisplay">
            <button class="filter" data-podcast="alle">Alle</button>

        </ul>

    </nav>
    <nav id="filtrering2">
        <div id="filterknap2"><button class="filter2" data-podcast2="a-z">A-Z</button></div>
        <ul id="menu2" class="filterdisplay">
            <ul id="menu2" class="show2">


                <button class="filter" data-podcast2="A">A</button><button class="filter" data-podcast2="B">B</button><button class="filter" data-podcast2="C">C</button><button class="filter" data-podcast2="D">D</button><button class="filter" data-podcast2="E">E</button><button class="filter" data-podcast2="F">F</button><button class="filter" data-podcast2="G">G</button><button class="filter" data-podcast2="H">H</button><button class="filter" data-podcast2="I">I</button><button class="filter" data-podcast2="J">J</button><button class="filter" data-podcast2="K">K</button><button class="filter" data-podcast2="L">L</button><button class="filter" data-podcast2="M">M</button><button class="filter" data-podcast2="N">N</button><button class="filter" data-podcast2="O">O</button><button class="filter" data-podcast2="P">P</button><button class="filter" data-podcast2="Q">Q</button><button class="filter" data-podcast2="R">R</button><button class="filter" data-podcast2="S">S</button><button class="filter" data-podcast2="T">T</button><button class="filter" data-podcast2="U">U</button><button class="filter" data-podcast2="V">V</button><button class="filter" data-podcast2="W">W</button><button class="filter" data-podcast2="X">X</button><button class="filter" data-podcast2="Y">Y</button><button class="filter" data-podcast2="Z">Z</button><button class="filter" data-podcast2="Å">Å</button><button class="filter" data-podcast2="Æ">Æ</button><button class="filter" data-podcast2="Ø">Ø</button>
            </ul>

        </ul>
    </nav>
    <section class="container"></section>
</main>
<script>
    let podcasts;


    let categories;
    let filterPodcast = "alle";
    let filterPodcast2 = "a-z";

    const dbUrl = "http://linegommesen.com/kea/radio_loud/wp-json/wp/v2/podcast?per_page=100";

    const catUrl = "http://linegommesen.com/kea/radio_loud/wp-json/wp/v2/categories?per_page=100";

    async function getJson() {
        const data = await fetch(dbUrl);
        const catdata = await fetch(catUrl);

        podcasts = await data.json();
        categories = await catdata.json();
        console.log(categories);
        visPodcasts();
        visPodcasts2();
        opretKnapper();
        opretKnapper2();
        sidenVises();
    }

    function opretKnapper() {
        categories.forEach(cat => {
            document.querySelector("#filtrering ul").innerHTML += `<button class="filter" data-podcast="${cat.id}">${cat.name}</button>`
        })
        addEventListenersToButtons();
    }

    function opretKnapper2() {
        //     genre.sort(compare);
        // console.log("genre: ", genre);
        // genre.forEach(gen => {
        // document.querySelector("#filtrering2 ul").innerHTML += `<button class="filter" data-podcast2="${gen.name}">${gen.name}</button>`
        // })
        addEventListenersToButtons2();


    }

    function compare(a, b) {
        if (a.name < b.name) {
            return -1;
        }
        if (a.name > b.name) {
            return 1;
        }
        return 0;
    }



    function addEventListenersToButtons() {
        document.querySelectorAll("#filtrering button").forEach(elm => {
            elm.addEventListener("click", filtrering);
        })
    };

    function addEventListenersToButtons2() {
        document.querySelectorAll("#filtrering2 button").forEach(elm => {
            elm.addEventListener("click", filtrering2);
        })
    };

    function filtrering() {
        filterPodcast = this.dataset.podcast;
        console.log(filterPodcast);
        visPodcasts();
    }

    function filtrering2() {
        filterPodcast2 = this.dataset.podcast2;
        console.log(filterPodcast2);
        visPodcasts2();
    }

    function visPodcasts() {
        let temp = document.querySelector("template");
        let container = document.querySelector(".container")
        container.innerHTML = "";
        podcasts.forEach(podcast => {
            if (filterPodcast == "alle" || podcast.categories.includes(parseInt(filterPodcast))) {
                let klon = temp.cloneNode(true).content;
                klon.querySelector("h2").innerHTML = podcast.title.rendered;
                klon.querySelector(".billede").src = podcast.billede.guid;
                klon.querySelector(".beskrivelse_kort").textContent = podcast.beskrivelse_kort;

                klon.querySelector("article").addEventListener("click", () => {
                    location.href = podcast.link;
                })
                container.appendChild(klon);
            }
        })
    }

    function visPodcasts2() {
        let temp = document.querySelector("template");
        let container = document.querySelector(".container")
        container.innerHTML = "";
        console.log("podcasts: ", podcasts);
        console.log("filterpodcast2: ", filterPodcast2);
        podcasts.forEach(podcast => {
            if (filterPodcast2 == "a-z" || podcast.title.rendered.charAt(0) == filterPodcast2) {
                let klon = temp.cloneNode(true).content;
                klon.querySelector("h2").innerHTML = podcast.title.rendered;
                klon.querySelector(".billede").src = podcast.billede.guid;
                klon.querySelector(".beskrivelse_kort").textContent = podcast.beskrivelse_kort;

                klon.querySelector("article").addEventListener("click", () => {
                    location.href = podcast.link;
                })
                container.appendChild(klon);
            }
        })
    }
    getJson();

    /* document.addEventListener("DOMContentLoaded", sidenVises); */

    function sidenVises() {
        console.log("sidenVises");
        document.querySelector("#filtrering #filterknap").addEventListener("click", toggleMenu);
        document.querySelector("#filtrering2 #filterknap2").addEventListener("click", toggleMenu2);
    }

    function toggleMenu() {
        console.log("toggleMenu");
        document.querySelector("#menu").classList.toggle("filterdisplay");
        document.querySelector("#menu").classList.toggle("show");

        let erSkjult = document.querySelector("#menu").classList.contains("filterdisplay");

        if (erSkjult == true) {
            document.querySelector("#filterknap").innerHTML = `<img src="http://linegommesen.com/kea/radio_loud/wp-content/themes/childtheme/img/filter.png" alt="Filter">`;
        } else {
            document.querySelector("#filterknap").innerHTML = `<img src="http://linegommesen.com/kea/radio_loud/wp-content/themes/childtheme/img/X.png" alt="Kryds">`;
        }
    }

    function toggleMenu2() {
        console.log("toggleMenu2");
        document.querySelector("#menu2").classList.toggle("filterdisplay");
        document.querySelector("#menu2").classList.toggle("show2");

        let erSkjult2 = document.querySelector("#menu2").classList.contains("filterdisplay");

    }

</script>

<?php //get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
