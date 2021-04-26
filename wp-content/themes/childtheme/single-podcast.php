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
                </article>
            </template>
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

                container.appendChild(klon);
            }
        })
    }
    getJson();

</script>

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
