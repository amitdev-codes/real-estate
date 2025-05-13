import axios from 'axios';

export default {
  async fetchMedia(model, modelId, collection) {
    try {
      const response = await axios.get(`/api/${model}/${modelId}/${collection}`);
      return response.data;
    } catch (error) {
      console.error(`Error fetching ${collection} media:`, error);
      throw error;
    }
  },

  async removeMedia(mediaId) {
    try {
      await axios.delete(`/api/media/${mediaId}`);
      return true;
    } catch (error) {
      console.error("Error removing media:", error);
      throw error;
    }
  },

  async uploadMedia(formData, onProgressCallback = null) {
    try {
      const response = await axios.post('/api/media/upload', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        },
        onUploadProgress: onProgressCallback
      });
      return response.data;
    } catch (error) {
      console.error("Error uploading media:", error);
      throw error;
    }
  }
};
