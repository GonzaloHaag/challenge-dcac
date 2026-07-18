const API_BASE_URL = 'http://localhost:8080';


export async function getAllProducts() {
    try {
        const response = await fetch(`${API_BASE_URL}/productos`);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const products = await response.json();
        return products;
    }
    catch (error) {
        console.error('Error fetching products:', error);
        throw error;
    }
}

export async function getProductById(productId) {
    try {
        const response = await fetch(`${API_BASE_URL}/productos/${productId}`);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const product = await response.json();
        return product;
    }
    catch (error) {
        console.error(`Error fetching product with ID ${productId}:`, error);
        throw error;
    }
}

export async function createProduct(productData) {
    try {
        const response = await fetch(`${API_BASE_URL}/productos`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(productData),
        });
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const newProduct = await response.json();
        return newProduct;
    }
    catch (error) {
        console.error('Error creating product:', error);
        throw error;
    }
}

export async function updateProduct(productId, productData) {
    try {
        const response = await fetch(`${API_BASE_URL}/productos/${productId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(productData),
        });
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const updatedProduct = await response.json();
        return updatedProduct;
    }
    catch (error) {
        console.error(`Error updating product with ID ${productId}:`, error);
        throw error;
    }
}

export async function deleteProduct(productId) {
    try {
        const response = await fetch(`${API_BASE_URL}/productos/${productId}`, {
            method: 'DELETE',
        });
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return true;
    }
    catch (error) {
        console.error(`Error deleting product with ID ${productId}:`, error);
        throw error;
    }
}