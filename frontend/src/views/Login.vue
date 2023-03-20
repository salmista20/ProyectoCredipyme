<template>
	<div id="login-content">
		<div class="wrapper">
			<div class="logo">
				<img src="@/assets/images/general/logo-corto-azul.svg" alt="" />
			</div>
			<div class="text-center mt-3 mb-2 name">Credipyme Online</div>
			<div class="p-3 mt-3">
				<div class="form-field d-flex align-items-center">
					<i class="pi pi-user"></i>
					<input
						type="text"
						placeholder="DNI"
						v-model="frmDatosAcceso.dni"
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
				<button class="btn mt-3" @click="Acceder">Login</button>
			</div>
			<div class="text-center fs-6">
				<a href="#">Olvidaste tu contraseña?</a>
			</div>
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
				dni: null,
				clave: null,
			},
		};
	},
	validations: {
		frmDatosAcceso: {
			dni: { required },
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

			let dni = this.frmDatosAcceso.dni;
			let clave = this.frmDatosAcceso.clave;

			await axios
				.get(api_url + "/acceso/cliente/" + dni + "/" + clave)
				.then(function (response) {
					if (response.data != "NO_AUTORIZADO") {
						self.storage.setStorageSync("cliente", response.data);
						return self.$router.push({
							name: "Home",
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

<style>
</style>