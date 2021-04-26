<?php
/**
 * The template for displaying single posts and pages.
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

<main id="site-content" role="main">

<section class="container"></section>

</main><!-- #site-content -->
  <script>

        let podcasts;

        const dbUrl = "http://linegommesen.com/kea/radio_loud/wp-json/wp/v2/podcast";

        async function getJson() {
            const data = await fetch(dbUrl);
            podcasts = await data.json();
            console.log(podcasts);
            visPodcasts();
        }

        function visPodcasts() {
            let temp = document.querySelector("template");
            let container = document.querySelector(".container")
            podcasts.forEach(podcast => {
                let klon = temp.cloneNode(true).content;
                klon.querySelector("h2").textContent = podcast.title.rendered;
                klon.querySelector(".billede").src = podcast.billede.guid;
                klon.querySelector(".beskrivelse_kort").textContent = podcast.beskrivelse_kort;

                klon.querySelector("article").addEventListener("click", ()=> {location.href = podcast.link;})
                container.appendChild(klon);

            })
        }
        getJson();
    </script>

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>
