export async function handleResponse(response) {
    if(response.status === 204) return null;

    const data = await response.json();

    if (!response.ok) {
        throw new Error(data.error ?? `Error HTTP ${response.status}`);
    }

    return data;
}