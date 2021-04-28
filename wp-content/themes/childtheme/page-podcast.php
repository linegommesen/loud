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
        <img src="http://linegommesen.com/kea/radio_loud/wp-content/themes/childtheme/img/podcasts_banner.png" alt="">
    </section>

    <nav id="filtrering">
        <div id="filterknap">☰</div>
        <ul id="menu" class="hidden">
            <button class="filter" data-podcast="alle">Alle</button>

        </ul>

    </nav>
    <section class="container"></section>
</main>
<script>
    let podcasts;
    let categories;
    let filterPodcast = "alle";

    const dbUrl = "http://linegommesen.com/kea/radio_loud/wp-json/wp/v2/podcast?per_page=100";

    const catUrl = "http://linegommesen.com/kea/radio_loud/wp-json/wp/v2/categories?per_page=100";

    async function getJson() {
        const data = await fetch(dbUrl);
        const catdata = await fetch(catUrl);
        podcasts = await data.json();
        categories = await catdata.json();
        /* console.log(categories); */
        visPodcasts();
        opretKnapper();
        sidenVises();
    }

    function opretKnapper() {
        categories.forEach(cat => {
            document.querySelector("#filtrering ul").innerHTML += `<button class="filter" data-podcast="${cat.id}">${cat.name}</button>`
        })
        addEventListenersToButtons();
    }

    function addEventListenersToButtons() {
        document.querySelectorAll("#filtrering button").forEach(elm => {
            elm.addEventListener("click", filtrering);
        })
    };

    function filtrering() {
        filterPodcast = this.dataset.podcast;
        console.log(filterPodcast);
        visPodcasts();
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
    getJson();

    /* document.addEventListener("DOMContentLoaded", sidenVises); */

    function sidenVises() {
        console.log("sidenVises");
        document.querySelector("#filtrering #filterknap").addEventListener("click", toggleMenu);
    }

    function toggleMenu() {
        console.log("toggleMenu");
        document.querySelector("#menu").classList.toggle("hidden");

        let erSkjult = document.querySelector("#menu").classList.contains("hidden");

        if (erSkjult == true) {
            document.querySelector("#filterknap").textContent = "☰";
        } else {
            document.querySelector("#filterknap").textContent = "X";
        }
    }

</script>

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
