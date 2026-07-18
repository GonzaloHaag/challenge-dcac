
import { getAllProducts } from "./api/product.service.js";
import { renderProducts } from "./views/products-table.view.js";

async function init() {
    const products = await getAllProducts();
    renderProducts(products);
}

init();