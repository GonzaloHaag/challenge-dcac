import { getProductById } from "./api/product.service.js";
import { renderProductDetail } from "./views/product-detail.view.js";

async function init() {
    const params = new URLSearchParams(window.location.search);
    const id = params.get("id");
    if(!id) return;

    const product = await getProductById(id);

    renderProductDetail(product);
}

init();