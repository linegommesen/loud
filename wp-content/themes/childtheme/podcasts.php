

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">

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

 <h2 class="overskrift">NYESTE EPISODER</h2>
        <p class="tekst">Find de nyeste episoder af vores podcast her!</p>
    <section class="container">

    </section>
    <script>

        let podcasts;

        const dbUrl = "http://linegommesen.com/kea/radio_loud/wp-json/wp/v2/podcast?per_page=9";

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




