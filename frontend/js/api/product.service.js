import { handleResponse } from "./http.js";

const API_BASE_URL = "http://localhost:8080";

export async function getAllProducts() {
  const response = await fetch(`${API_BASE_URL}/productos`);
  return handleResponse(response);
}

export async function getProductById(productId) {
  const response = await fetch(`${API_BASE_URL}/productos/${productId}`);
  return handleResponse(response);
}

export async function createProduct(payload) {
    const response = await fetch(`${API_BASE_URL}/productos`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(payload),
    });
   return handleResponse(response);
}

export async function updateProduct(productId, productData) {
    const response = await fetch(`${API_BASE_URL}/productos/${productId}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(productData),
    });
    return handleResponse(response);
}

export async function deleteProduct(productId) {
    const response = await fetch(`${API_BASE_URL}/productos/${productId}`, {
      method: "DELETE",
    });
    return handleResponse(response);
}
