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
<section id="primary" class="content-area">
    <main id="main" class="site-main">

        <img class="banner" src="" alt="">
        <h1>EPISODER</h1>


        <section id="episoder">
            <template>
                <article class="episode_enkelt">
                    <img class="billede" src="" alt="">
                    <div>
                        <h2></h2>
                        <p class="beskrivelse_kort"></p>
                    </div>
             <div class="ikoner">
                 <img class="spotify ikon" src="" alt="">
                 <img class="podimo ikon" src="" alt="">
                 <img class="apple ikon" src="" alt="">
                 <img class="google ikon" src="" alt="">

             </div>
                </article>
            </template>

<!--
                   <div class="ikoner">
               <a href="https://podimo.com/dk/?utm_source=google&utm_medium=cpc_brand&utm_campaign=DK_PERFORMANCE_SEARCH_BRAND&utm_term=Podimo_exact-match&utm_content=BrandedSearches&gclid=Cj0KCQjwyZmEBhCpARIsALIzmnKY5SyzX3kmSmV-WLgnoOGY2cy-BUdxB_w6sS9GYEF6_G_qbQI78k8aAntxEALw_wcB"> <img src="img/podimo-podcasts-seeklogo.com.png" alt="podimo"></a>
                <a href="https://www.spotify.com/dk-en/premium/?utm_source=dk_brand_contextual_text&utm_medium=paidsearch&utm_campaign=alwayson_europe_dk_performancemarketing_core_brand+contextual+text+exact+dk+google&gclid=Cj0KCQjwyZmEBhCpARIsALIzmnIlcYTvefMRpHTJJHKfnUnuPUYdjezcmQCHD0tur4DaYhhjQFbBaV8aAtHDEALw_wcB&gclsrc=aw.ds"> <img src="img/spotify-podcasts-seeklogo.com.png" alt="spotify"></a>
                <a href="https://www.apple.com/itunes/"> <img src="img/apple-podcasts-seeklogo.com.png" alt="apple podcast"></a>
                <a href="https://podcasts.google.com/"> <img src="img/google-podcasts-seeklogo.com.png" alt="google podcast"></a>

            </div>
-->
        </section>
    </main>
</section>

<script>
    let podcast;
    let episoder;
    let aktuelPodcast = <?php echo get_the_ID() ?>;

    const dbUrl = "http://linegommesen.com/kea/radio_loud/wp-json/wp/v2/podcast/" + aktuelPodcast;
    const episodeUrl = "http://linegommesen.com/kea/radio_loud/wp-json/wp/v2/episoder?per_page=100";

    const container = document.querySelector("#episoder");

    async function getJson() {
        const data = await fetch(dbUrl);
        podcast = await data.json();

        const data2 = await fetch(episodeUrl);
        episoder = await data2.json();
        console.log("episoder: ", episoder);

        visPodcasts();
        visEpisoder();
    }

    function visPodcasts() {
        console.log("visPodcast");
        console.log(podcast.title.rendered);
        document.querySelector(".banner").src = podcast.banner.guid;
        console.log(podcast.banner.guid);
    }

    function visEpisoder() {
        console.log("visEpisoder");
        let temp = document.querySelector("template");
        //        let container = document.querySelector(".container")
        episoder.forEach(episode => {
            console.log("loop id :", aktuelPodcast);
            if (episode.horer_til_podcast == aktuelPodcast) {
                console.log("loop kører id :", aktuelPodcast);
                let klon = temp.cloneNode(true).content;
                klon.querySelector("h2").textContent = episode.title.rendered;
                klon.querySelector(".billede").src = episode.billede.guid;
                klon.querySelector(".beskrivelse_kort").textContent = episode.beskrivelse_kort;
                klon.querySelector(".spotify"). src = "http://linegommesen.com/kea/radio_loud/wp-content/themes/childtheme/img/spotify-podcasts-seeklogo.com.png";
                klon.querySelector(".podimo"). src = "http://linegommesen.com/kea/radio_loud/wp-content/themes/childtheme/img/podimo-podcasts-seeklogo.com.png";
                klon.querySelector(".apple"). src = "http://linegommesen.com/kea/radio_loud/wp-content/themes/childtheme/img/apple-podcasts-seeklogo.com.png";
                klon.querySelector(".google"). src = "http://linegommesen.com/kea/radio_loud/wp-content/themes/childtheme/img/google-podcasts-seeklogo.com.png";

                container.appendChild(klon);
            }
        })
    }
    getJson();

</script>

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
