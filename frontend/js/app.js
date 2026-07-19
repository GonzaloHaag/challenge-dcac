import { getAllProducts, deleteProduct } from "./api/product.service.js";
import { renderProducts } from "./views/products-table.view.js";

async function loadProducts() {
  const products = await getAllProducts();
  renderProducts(products);
}

async function init() {
  try {
    await loadProducts();
  } catch (error) {
    console.error("Error al obtener los productos:", error);
    alert(error.message);
  }
}

document.querySelector('#products-table-body').addEventListener('click', async (event) => {
  const button = event.target.closest('.btn-delete');
  if (!button) return;

  if (!confirm('¿Seguro que querés eliminar este producto?')) return;

  try {
    await deleteProduct(button.dataset.id);
    await loadProducts();
  } catch (error) {
    console.error("Error al eliminar el producto:", error);
    alert(error.message);
  }
});

init();
