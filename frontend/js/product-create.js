import { createProduct } from "./api/product.service.js";

const form = document.getElementById('product-form');

form.addEventListener('submit', async (event) => {
    event.preventDefault();

    const formData = new FormData(form);
    const payload = Object.fromEntries(formData.entries());

    payload.precio = Number(payload.precio);

    if(payload.precio < 0) {
        alert('El numero no puede ser negativo.');
        return;
    }
    try {
        const response = await createProduct(payload);
        window.location.href = `product-detail.html?id=${response.id}`;
    } catch (error) {
        console.error("Error al crear el producto:", error);
        alert('Hubo un error al crear el producto. Por favor, inténtelo de nuevo.');
    }
});