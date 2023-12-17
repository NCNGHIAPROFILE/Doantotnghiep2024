<template>
  <div>
    <v-btn @click="downloadFile">Tải Xuống</v-btn>
  </div>
</template>

<script>
  import Request from "@/plugins/request.js";
  import jsPDF from 'jspdf';

export default {
  methods: {
    downloadFile() {
      Request.get('Books/DownloadPDF/9')
        .then(response => {
          console.error(response);
          const pdf = new jsPDF();

          // Add text to the PDF
          pdf.text(response.data, 10, 10);

          // Save or download the PDF
          pdf.save('output.pdf');
        })
        .catch(error => {
          console.error('Error downloading file', error);
        });
    }
  }
};
</script>
