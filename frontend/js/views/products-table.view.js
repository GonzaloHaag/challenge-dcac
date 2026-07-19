import { formatCurrency } from "../utils/formatter.js";


export function renderProducts(products) {

    const productTableBody = document.querySelector('#products-table-body');

    productTableBody.innerHTML = '';

    if(products.length === 0) {
        productTableBody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center">No hay productos disponibles</td>
            </tr>
        `;
        return;
    }

    products.forEach((product) => {
        const tableRowElement = document.createElement('tr');
        tableRowElement.innerHTML = `
            <td>${product.id}</td>
            <td>${product.nombre}</td>
            <td>${product.descripcion ?? 'Sin descripción'}</td>
            <td>${formatCurrency(product.precio, 'ARS')}</td>
            <td>${formatCurrency(product.precio_usd, 'USD')}</td>
            <td class="td-actions">
                <a href="product-detail.html?id=${product.id}" title="Ver detalle" class="btn btn-edit">
                    Ver detalle
                </a>

                <button data-id="${product.id}" class="btn btn-delete">
                    Eliminar
                </button>
            </td>
        `;

        productTableBody.appendChild(tableRowElement);
    });
}