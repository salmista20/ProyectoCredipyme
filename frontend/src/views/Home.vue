<template>
	<div>
		<HeaderNav />
	</div>
</template>

<script>
import { useStorage } from "vue3-storage";
import HeaderNav from "@/components/HeaderNav.vue";
export default {
	setup() {
		return { storage: useStorage() };
	},
	components: {
		HeaderNav,
	},
	data() {
		return {
			// cliente: this.storage.getStorageSync("cliente"),
		};
	},
	computed: {
		nombre_cliente() {
			// return (
			// 	this.cliente.nombres +
			// 	" " +
			// 	this.cliente.apellido_paterno +
			// 	" " +
			// 	this.cliente.apellido_materno
			// );
		},
	},

	mounted() {
		// this.$swal({
		// 	icon: "success",
		// 	title: "BIENVENIDO",
		// 	text: this.nombre_cliente,
		// 	timer: 1200,
		// 	showConfirmButton: false,
		// });
	},
};
</script>

<style lang="scss">
</style>