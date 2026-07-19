import { formatCurrency } from "../utils/formatter.js";

export function renderProductDetail(product) {
    const productDetailContainer = document.querySelector('#product-detail-container');

    productDetailContainer.innerHTML = `
        <div class="product-detail-header">
           <h2>Detalle del Producto: ${product.nombre}</h2>
           <div class="td-actions">
               <a href="product-edit.html?id=${product.id}" title="Editar producto" class="btn btn-outline">
                   Editar
               </a>
               <a href="index.html" title="Ver lista" class="btn">
               Ver lista de productos
               </a>
           </div>
        </div>
        <p><strong>ID:</strong> ${product.id}</p>
        <p><strong>Nombre:</strong> ${product.nombre}</p>
        <p><strong>Descripción:</strong> ${product.descripcion ?? 'Sin descripción'}</p>
        <p><strong>Precio:</strong> ${formatCurrency(product.precio, 'ARS')}</p>
        <p><strong>Precio USD:</strong> ${formatCurrency(product.precio_usd, 'USD')}</p>
    `;
}