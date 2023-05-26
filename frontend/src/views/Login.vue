<template>
	<div id="login-content">
		<div class="wrapper">
			<div class="logo">
				<img src="@/assets/images/general/logo-corto-azul.svg" alt="" />
			</div>
			<div class="text-center mt-3 mb-2 name">Corporación Credipyme</div>
			<div class="p-3 mt-3">
				<form @submit.prevent="Acceder">
					<div class="form-field d-flex align-items-center">
						<i class="pi pi-user"></i>
						<input
							type="text"
							placeholder="Usuario"
							v-model="frmDatosAcceso.usuario"
							spellcheck="false"
							autocomplete="false"
						/>
					</div>
					<div class="form-field d-flex align-items-center">
						<i class="pi pi-key"></i>
						<input
							type="password"
							placeholder="Clave"
							v-model="frmDatosAcceso.clave"
							spellcheck="false"
							autocomplete="false"
						/>
					</div>
					<button type="submit" class="btn mt-3">INGRESAR</button>
				</form>
			</div>
			<!-- <div class="text-center fs-6">
				<a href="#">Olvidaste tu contraseña?</a>
			</div> -->
		</div>
	</div>
</template>

<script>
import "@/assets/sass/login.scss";
import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import { useStorage } from "vue3-storage";
const api_url = import.meta.env.VITE_API_URL;

export default {
	setup() {
		return { v$: useVuelidate(), storage: useStorage() };
	},
	data() {
		return {
			submited: false,
			frmDatosAcceso: {
				usuario: null,
				clave: null,
			},
		};
	},
	validations: {
		frmDatosAcceso: {
			usuario: { required },
			clave: { required },
		},
	},
	methods: {
		async Acceder() {
			let self = this;
			if (this.v$.$invalid) {
				this.$swal.fire({
					icon: "error",
					title: "¡Ups!",
					text: "Hay uno o más campos vacíos, verifique.",
				});
				return false;
			}

			let usuario = this.frmDatosAcceso.usuario;
			let clave = this.frmDatosAcceso.clave;

			await axios
				.get(api_url + "/login/acceder/" + usuario + "/" + clave)
				.then(function (response) {
					// console.log(response.data);
					// return false;
					if (response.data.resultado != "NO_AUTORIZADO") {
						self.storage.setStorageSync(
							"datos_sesion",
							response.data.datos_sesion
						);
						self.storage.setStorageSync("agencias", response.data.agencias);
						return self.$router.push({
							name: "Home",
							params: { showMessage: 1 },
						});
					} else {
						self.$swal.fire({
							icon: "error",
							title: "¡Ups!",
							text: "Sus credenciales son incorrectas.",
						});
						return false;
					}
				});
		},
	},
};
</script>

<style lang="scss">
</style>