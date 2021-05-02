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
        <div id="filterknap"><img src="http://linegommesen.com/kea/radio_loud/wp-content/themes/childtheme/img/filter.png" alt="Filter"></div>
        <ul id="menu" class="filterdisplay">
            <button class="filter" data-podcast="alle">Alle</button>

        </ul>

    </nav>
    <nav id="filtrering2">
       <div id="filterknap2"><button class="filter2">A-Z</button></div>
        <ul id="menu2" class="filterdisplay">


        </ul>
    </nav>
    <section class="container"></section>
</main>
<script>

    let podcasts;
    let categories;

    let genre;
    let filterPodcast = "alle";
    let filterPodcast2 = "a-z";

    const dbUrl = "http://linegommesen.com/kea/radio_loud/wp-json/wp/v2/podcast?per_page=100";

    const catUrl = "http://linegommesen.com/kea/radio_loud/wp-json/wp/v2/categories?per_page=100";

    const genreUrl = "http://linegommesen.com/kea/radio_loud/wp-json/wp/v2/genres?per_page=100";

    async function getJson() {
        const data = await fetch(dbUrl);
        const catdata = await fetch(catUrl);
        const genredata = await fetch(genreUrl);
        podcasts = await data.json();
        categories = await catdata.json();
        genre = await genredata.json();
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
        genre.forEach(gen => {
            document.querySelector("#filtrering2 ul").innerHTML += `<button class="filter" data-podcast="${gen.id}">${gen.name}</button>`
        })
        addEventListenersToButtons2();
        genre.sort();
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
        filterPodcast2 = this.dataset.podcast;
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
        podcasts.forEach(podcast => {
            if (filterPodcast2 == "a-z" || podcast.genre.includes(parseInt(filterPodcast2))) {
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

        if (erSkjult2 == true) {
            document.querySelector("#filterknap2").innerHTML = `<button class="filter2">A-Z</button>`;
        } else {
            document.querySelector("#filterknap2").innerHTML = `<button class="filter2">A-Z</button>>`;
        }
    }

</script>

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
