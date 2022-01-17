<script>
	import { createEventDispatcher } from "svelte";
	const dispatch = createEventDispatcher();

	export let pokemons = [];
</script>

<ul>
	{#each pokemons as poke}
		<li>
			<a href="/" on:click|preventDefault={dispatch("pokemonClicked", { id: poke.id })}>{poke.name}</a>
		</li>
	{/each}
</ul>
