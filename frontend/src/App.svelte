<script>
	import "../node_modules/@picocss/pico/css/pico.min.css";
	import { onMount } from "svelte";
	import SinglePokemon from "./SinglePokemon.svelte";
	import AddPokemon from "./AddPokemon.svelte";
	import PokemonsList from "./PokemonsList.svelte";
	import { getAllPokemon, getOnePokemon } from "../services/crud";

	let pokemons = ["Loading..."];
	let single;

	$: count = pokemons.length;

	onMount(async () => {
		refreshPokemons();
	});

	async function refreshPokemons() {
		pokemons = await getAllPokemon();
	}

	async function loadPokemon(event) {
		const id = event.detail.id;
		single = await getOnePokemon(id);
	}

	function clearAndRefreshPokemons() {
		refreshPokemons();
		single = {};
	}
</script>

<main class="container">
	<h1>{count} Pokemons</h1>
	<div class="grid">
		<div>
			<PokemonsList {pokemons} on:pokemonClicked={loadPokemon} />
		</div>
		<div>
			<AddPokemon on:created={refreshPokemons} />
		</div>
	</div>
	<hr />
	<SinglePokemon
		pokemon={single}
		on:deleted={clearAndRefreshPokemons}
		on:updated={refreshPokemons}
	/>
</main>
