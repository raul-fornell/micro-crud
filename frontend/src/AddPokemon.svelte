<script>
	import { createEventDispatcher } from "svelte";
	import { addNewPokemon } from "../services/crud";
	const dispatch = createEventDispatcher();

	let name, type;

	async function doAdd() {
		const data = { name, type };
		await addNewPokemon(data);
		dispatch("created");
	}
</script>

<fieldset>
	<h4>Add new</h4>
	<label for="name">Name</label>
	<input bind:value={name} type="text" name="name" />

	<label for="type">Type</label>
	<input bind:value={type} type="text" name="type" />
	<button on:click={doAdd}>Add</button>
</fieldset>
