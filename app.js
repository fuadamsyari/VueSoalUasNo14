new Vue({
  el: '#app',
  data: {
    kendaraans: [],
    newKendaraan: {
      nama_mobil: '',
      merk: '',
      warna: '',
      nopol: '',
      harga: 0,
    },
  },
  mounted() {
    this.fetchKendaraans();
  },
  methods: {
    fetchKendaraans() {
      axios
        .get('api.php?action=get_kendaraans')
        .then((response) => {
          this.kendaraans = response.data;
        })
        .catch((error) => {
          console.error('Error fetching data:', error);
        });
    },
    addKendaraan() {
      axios
        .post('api.php?action=add_kendaraan', this.newKendaraan)
        .then((response) => {
          this.newKendaraan = {
            nama_mobil: '',
            merk: '',
            warna: '',
            nopol: '',
            harga: 0,
          };
          this.fetchKendaraans();
        })
        .catch((error) => {
          console.error('Error adding data:', error);
        });
    },
    deleteKendaraan(id) {
      axios
        .delete(`api.php?action=delete_kendaraan&id=${id}`)
        .then((response) => {
          this.fetchKendaraans();
        })
        .catch((error) => {
          console.error('Error deleting data:', error);
        });
    },
  },
});
