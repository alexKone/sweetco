export const API = {
  getItems: async () => {
    const response = await fetch('/api/currentSession');
    return await response.json()
  }
};
