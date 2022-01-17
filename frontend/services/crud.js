import { SERVER_URL } from "../config";

const url = SERVER_URL;

export async function addNewPokemon(data) {
    await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
    });
}

export async function deletePokemon(id) {
    await fetch(`${url}/${id}`, {
        method: "DELETE",
    });
}

export async function updatePokemon(data, id) {
    await fetch(`${url}/${id}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
    });
}

export async function getAllPokemon() {
    return await (await fetch(url)).json();
}

export async function getOnePokemon(id) {
    return await (await fetch(`${url}/${id}`)).json();
}
