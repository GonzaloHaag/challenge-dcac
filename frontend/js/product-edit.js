import { getProductById, updateProduct } from "./api/product.service.js";

const form = document.getElementById('product-form');
const params = new URLSearchParams(window.location.search);
const id = params.get('id');

async function init() {
    if (!id) {
        alert('No se especificó un producto para editar.');
        window.location.href = 'index.html';
        return;
    }

    try {
        const product = await getProductById(id);
        form.nombre.value = product.nombre;
        form.descripcion.value = product.descripcion ?? '';
        form.precio.value = product.precio;
    } catch (error) {
        console.error('Error al obtener el producto:', error);
        alert(error.message);
    }
}

form.addEventListener('submit', async (event) => {
    event.preventDefault();

    const formData = new FormData(form);
    const payload = Object.fromEntries(formData.entries());

    payload.precio = Number(payload.precio);

    if (payload.precio < 0) {
        alert('El numero no puede ser negativo.');
        return;
    }

    try {
        await updateProduct(id, payload);
        window.location.href = `product-detail.html?id=${id}`;
    } catch (error) {
        console.error('Error al actualizar el producto:', error);
        alert(error.message);
    }
});

init();
