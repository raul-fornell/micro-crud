<script>
	import { createEventDispatcher } from "svelte";
	import { deletePokemon, updatePokemon} from "../services/crud";
	
	const dispatch = createEventDispatcher();

	export let pokemon = {};
	let updatedName = "";
	let updatedType = "";

	async function doDelete() {
		await deletePokemon(pokemon.id);
		dispatch("deleted");
	}

	async function doUpdate() {
		const data = {
			name: updatedName || pokemon.name,
			type: updatedType || pokemon.type,
		};
		await updatePokemon(data, pokemon.id);
		dispatch("updated");
	}

	function onNameChange(event) {
		updatedName = event.target.innerText;
	}

	function onTypeChange(event) {
		updatedType = event.target.innerText;
	}

	$: {
		updatedName = pokemon.name;
		updatedName = "";
		updatedType = "";
	}	

	$: isEditable = updatedName !== "" || updatedType !== "";
</script>

<div>
	{#if pokemon.name}
		<h2 contenteditable="true" on:input={onNameChange}>{pokemon.name}</h2>
		<p>
			Type:
			<span contenteditable="true" on:input={onTypeChange}>{pokemon.type}</span>
		</p>
		{#if isEditable}
			<button on:click|preventDefault={doUpdate}>Save changes</button>	
		{/if}		
		<button on:click|preventDefault={doDelete}>Delete</button>
	{:else}
		<p>Pick one</p>
	{/if}
</div>

<style>
	button {
		display: inline-block;
		width: auto;
	}
</style>
