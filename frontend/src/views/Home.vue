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
			usuario: this.storage.getStorageSync("datos_sesion"),
		};
	},
	computed: {
		nombre_cliente() {
			return (
				this.usuario.nombres +
				" " +
				this.usuario.apellido_paterno +
				" " +
				this.usuario.apellido_materno
			);
		},
	},

	mounted() {
		this.$swal({
			icon: "success",
			title: "BIENVENIDO",
			text: this.nombre_cliente,
			timer: 1200,
			showConfirmButton: false,
		});
	},
};
</script>

<style lang="scss">
</style>