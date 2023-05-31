<template>
	<div>
		<HeaderNav />
		<div class="main-content">
			<div class="layout-px-spacing dash_1 slot-usuarios-gestion">
				<div class="row layout-top-spacing">
					<div class="layout-spacing">
						<div class="card component-card_1">
							<headerClose :title="'GESTIÓN DE USUARIOS'"></headerClose>
							<h5 class="card-title">LISTA DE RESULTADOS</h5>
							<div class="card-body">
								<div class="row mb-2 col-12">
									<div class="col-md-4 col-9">
										<div class="input-group">
											<span class="input-group-text"> AGENCIA </span>
											<select
												v-model="filters['agencia'].value"
												class="form-select text-center"
											>
												<option :value="null" selected>TODAS</option>
												<option
													v-for="item in agencias"
													:key="item.id"
													:value="item.agencia"
												>
													{{ item.agencia }}
												</option>
											</select>
										</div>
									</div>
									<div class="col-md-5 col-9">
										<div class="input-group">
											<span class="input-group-text">
												<i class="pi pi-search"></i>
											</span>
											<input
												v-model="filters['global'].value"
												class="form-control mayus"
												type="text"
												placeholder="Buscar..."
												autocomplete="off"
												spellcheck="false"
											/>
										</div>
									</div>

									<div class="col-md-3 col-3">
										<button
											type="button"
											class="btn btn-main-1 btn-icon-split"
											@click="Nuevo"
										>
											<i class="pi pi-plus"></i>
											<span class="text">NUEVO</span>
										</button>
									</div>
								</div>
								<DataTable
									:value="usuarios"
									:scrollable="true"
									scrollHeight="450px"
									scrollDirection="both"
									:filters="filters"
									:globalFilterFields="['agencia', 'colaborador']"
									:paginator="true"
									:rows="20"
									paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport"
									currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords} registro(s)"
								>
									<Column
										class="align-center"
										field="acciones"
										header="ACCIONES"
										style="width: 100px !important"
									>
										<template #body="{ data }">
											<div class="btn-group" role="group">
												<button
													class="btn btn-main-1 btn-sm"
													@click="Editar(data)"
												>
													<i class="pi pi-pencil"></i>
												</button>
												<button
													class="btn btn-main-2 btn-sm"
													@click="ModificarClave(data)"
												>
													<i class="pi pi-lock"></i>
												</button>
											</div>
										</template>
									</Column>
									<Column
										class="align-center"
										field="usuario"
										header="USUARIO"
										style="width: 100px !important"
									>
										<template #body="{ data }">
											{{ data.usuario }}
										</template>
									</Column>
									<Column
										field="trabajador"
										header="NOMBRE COMPLETO"
										style="min-width: 200px !important"
									>
										<template #body="{ data }">
											{{ data.colaborador }}
										</template>
									</Column>
									<Column
										class="align-center"
										field="dni"
										header="DNI"
										style="width: 100px !important"
									>
										<template #body="{ data }">
											{{ data.dni }}
										</template>
									</Column>
									<Column
										class="align-center"
										field="agencia"
										header="AGENCIA"
										style="width: 120px !important"
									>
										<template #body="{ data }">
											{{ data.agencia }}
										</template>
									</Column>

									<Column
										field="cargo"
										header="CARGO"
										style="width: 250px !important"
									>
										<template #body="{ data }">
											{{ data.cargo }}
										</template>
									</Column>
									<Column
										field="rol"
										header="ROL"
										style="width: 100px !important"
									>
										<template #body="{ data }">
											{{ data.rol }}
										</template>
									</Column>
									<Column
										class="align-center"
										field="habilitado"
										header="HABILITADO"
										style="width: 100px !important"
									>
										<template #body="{ data }">
											{{ data.habilitado ? "SI" : "NO" }}
										</template>
									</Column>
								</DataTable>
							</div>
						</div>
					</div>
				</div>
			</div>
			<Dialog
				class="mdlDatosUsuario"
				:visible="modal_datos_visible"
				:modal="true"
				@update:visible="Cerrar('mdlDatosUsuario')"
				:header="title_modal"
			>
				<div class="row">
					<div class="form-group col-md-4 offset-md-2">
						<label class="label-title">DNI</label>
						<input
							type="number"
							class="form-control center"
							:class="[
								submited && frmDatosUsuario.modo == 'NUEVO'
									? !v$.frmDatosUsuario.dni.$invalid
										? 'is-valid'
										: 'is-invalid'
									: '',
							]"
							min="0"
							maxlength="8"
							@keyup="Validar"
							v-model="frmDatosUsuario.dni"
							:disabled="frmDatosUsuario.modo == 'EDITAR'"
						/>
					</div>
					<div class="form-group col-md-4">
						<label class="label-title">USUARIO</label>
						<input
							type="text"
							class="form-control center"
							:class="[
								submited
									? !v$.frmDatosUsuario.usuario.$invalid
										? 'is-valid'
										: 'is-invalid'
									: '',
							]"
							v-model="frmDatosUsuario.usuario"
						/>
					</div>

					<div class="form-group col-md-4">
						<label class="label-title">APELLIDO PATERNO</label>

						<input
							type="text"
							class="form-control mayus"
							:class="[
								submited
									? !v$.frmDatosUsuario.apellido_paterno.$invalid
										? 'is-valid'
										: 'is-invalid'
									: '',
							]"
							v-model="frmDatosUsuario.apellido_paterno"
						/>
					</div>
					<div class="form-group col-md-4">
						<label class="label-title">APELLIDO MATERNO</label>

						<input
							type="text"
							class="form-control mayus"
							:class="[
								submited
									? !v$.frmDatosUsuario.apellido_materno.$invalid
										? 'is-valid'
										: 'is-invalid'
									: '',
							]"
							v-model="frmDatosUsuario.apellido_materno"
						/>
					</div>
					<div class="form-group col-md-4">
						<label class="label-title">NOMBRES</label>

						<input
							type="text"
							class="form-control mayus"
							:class="[
								submited
									? !v$.frmDatosUsuario.nombres.$invalid
										? 'is-valid'
										: 'is-invalid'
									: '',
							]"
							v-model="frmDatosUsuario.nombres"
						/>
					</div>

					<div class="form-group col-md-4">
						<label class="label-title">AGENCIA</label>

						<select
							class="form-select center"
							:class="[
								submited
									? !v$.frmDatosUsuario.agencia_id.$invalid
										? 'is-valid'
										: 'is-invalid'
									: '',
							]"
							v-model="frmDatosUsuario.agencia_id"
						>
							<option :value="0" disabled>Seleccione...</option>
							<option
								v-for="(item, index) in agencias"
								:key="index"
								:value="item.id"
							>
								{{ item.agencia }}
							</option>
						</select>
					</div>
					<div class="form-group col-md-8">
						<label class="label-title">CARGO</label>

						<select
							class="form-select"
							:class="[
								submited
									? !v$.frmDatosUsuario.cargo_id.$invalid
										? 'is-valid'
										: 'is-invalid'
									: '',
							]"
							v-model="frmDatosUsuario.cargo_id"
						>
							<option :value="0" disabled>Seleccione...</option>
							<option
								v-for="(item, index) in cargos"
								:key="index"
								:value="item.id"
							>
								{{ item.cargo }}
							</option>
						</select>
					</div>

					<div
						class="form-group col-md-4"
						v-if="frmDatosUsuario.habilitado"
					></div>
				</div>

				<hr />

				<div class="text-right">
					<div class="row">
						<div class="align-left col-md-6">
							<button
								type="button"
								class="btn btn-icon-split"
								:class="[
									frmDatosUsuario.habilitado ? 'btn-danger' : 'btn-success',
								]"
								@click="
									frmDatosUsuario.habilitado
										? ModificarHabilitado('DESHABILITAR')
										: ModificarHabilitado('HABILITAR')
								"
							>
								<i class="pi pi-ban"></i>
								<span class="text">{{
									frmDatosUsuario.habilitado ? "DESHABILITAR" : "HABILITAR"
								}}</span>
							</button>
						</div>
						<div class="col-md-6">
							<button
								type="button"
								class="btn btn-main-1 btn-icon-split"
								@click="Guardar"
							>
								<i class="pi pi-save"></i> <span class="text">GUARDAR</span>
							</button>
						</div>
					</div>
				</div>
			</Dialog>
			<Dialog
				class="mdlCambiarClave"
				:visible="modal_clave_visible"
				:modal="true"
				@update:visible="Cerrar('mdlCambiarClave')"
				:header="'CAMBIAR CLAVE'"
			>
				<div class="row">
					<div class="form-group col-md-6">
						<div class="input-group">
							<span class="input-group-text">DNI</span>

							<input
								class="form-control center"
								type="text"
								v-model="frmDatosClave.dni"
								:disabled="true"
							/>
						</div>
					</div>
					<div class="form-group col-md-6">
						<div class="input-group">
							<span class="input-group-text">USUARIO</span>

							<input
								class="form-control center"
								type="text"
								v-model="frmDatosClave.usuario"
								:disabled="true"
							/>
						</div>
					</div>

					<div class="form-group col-md-6">
						<label class="label-title">CLAVE NUEVA</label>

						<input
							class="form-control center"
							type="text"
							v-model="frmDatosClave.clave_nueva"
							:class="[
								submited
									? v$.frmDatosClave.clave_nueva.$invalid
										? 'is-invalid'
										: 'is-valid'
									: '',
							]"
						/>
					</div>

					<div class="form-group col-md-6">
						<label class="label-title">REPITA LA CLAVE</label>
						<input
							class="form-control center"
							type="text"
							v-model="frmDatosClave.clave_repetida"
							:class="[
								submited
									? v$.frmDatosClave.clave_nueva.$invalid
										? 'is-invalid'
										: 'is-valid'
									: '',
							]"
						/>
					</div>
				</div>
				<hr />
				<div class="text-right">
					<button
						type="button"
						class="btn btn-main-2 btn-icon-split"
						@click="GuardarClave"
					>
						<i class="pi pi-save"></i> <span class="text">GUARDAR</span>
					</button>
				</div>
			</Dialog>
		</div>
	</div>
</template>

<script>
import { useStorage } from "vue3-storage";
import HeaderNav from "@/components/HeaderNav.vue";
import HeaderClose from "@/components/HeaderClose.vue";

import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Dialog from "primevue/dialog";

import { FilterMatchMode } from "primevue/api";

import { useVuelidate } from "@vuelidate/core";
import { required } from "@vuelidate/validators";
const noZero = (value) => value != 0;
const api_url = import.meta.env.VITE_API_URL;
export default {
	setup() {
		return { v$: useVuelidate(), storage: useStorage() };
	},
	components: {
		HeaderNav,
		HeaderClose,

		DataTable,
		Column,
		Dialog,
	},
	data() {
		return {
			filters: {},

			usuarios: [],
			cargos: [],
			agencias: [],

			submited: false,
			modal_datos_visible: false,
			modal_clave_visible: false,
			title_modal: null,

			frmDatosUsuario: {
				id: null,
				dni: null,
				usuario: null,
				apellido_paterno: null,
				apellido_materno: null,
				nombres: null,
				agencia_id: 0,
				cargo_id: 0,
				modo: null,
			},
			frmDatosClave: {
				usuario_id: null,
				dni: null,
				usuario: null,
				clave_nueva: null,
				clave_repetida: null,
			},
		};
	},

	validations() {
		if (this.frmDatosUsuario.modo == "NUEVO") {
			return {
				frmDatosUsuario: {
					dni: { required },
					usuario: { required },
					apellido_paterno: { required },
					apellido_materno: { required },
					nombres: { required },
					agencia_id: { noZero },
					cargo_id: { noZero },
				},
			};
		} else if (this.frmDatosUsuario.modo == "EDITAR") {
			return {
				frmDatosUsuario: {
					usuario: { required },
					apellido_paterno: { required },
					apellido_materno: { required },
					nombres: { required },
					agencia_id: { noZero },
					cargo_id: { noZero },
				},
			};
		} else {
			return {
				frmDatosClave: {
					clave_nueva: { required },
					clave_repetida: { required },
				},
			};
		}
	},
	created() {
		this.filters = {
			global: { value: null, matchMode: FilterMatchMode.CONTAINS },
			agencia: { value: null, matchMode: FilterMatchMode.CONTAINS },
		};
	},
	mounted() {
		this.ListarRecursos();
	},

	methods: {
		async ListarRecursos() {
			let self = this;
			return await axios
				.get(api_url + "/usu/gestion/listar_recursos")
				.then(function (response) {
					self.usuarios = response.data.usuarios;
					self.cargos = response.data.cargos;
					self.agencias = response.data.agencias;
				});
		},
		Validar(e) {
			let maxlength = e.target.maxLength;
			let value = e.target.value;
			if (value.length > maxlength) {
				value = value.slice(0, maxlength);
				this.frmDatosUsuario.dni = value;
			}
		},
		Cerrar(modal) {
			this.submited = false;
			if (modal == "mdlDatosUsuario") {
				this.modal_datos_visible = false;
			} else if (modal == "mdlCambiarClave") {
				this.modal_clave_visible = false;
			}
		},
		Editar(item) {
			this.title_modal = "EDITAR USUARIO";
			this.frmDatosUsuario.modo = "EDITAR";

			this.frmDatosUsuario.id = item.id;
			this.frmDatosUsuario.dni = item.dni;
			this.frmDatosUsuario.usuario = item.usuario;
			this.frmDatosUsuario.apellido_paterno = item.apellido_paterno;
			this.frmDatosUsuario.apellido_materno = item.apellido_materno;
			this.frmDatosUsuario.nombres = item.nombres;
			this.frmDatosUsuario.agencia_id = item.agencia_id;
			this.frmDatosUsuario.cargo_id = item.cargo_id;
			this.frmDatosUsuario.habilitado = item.habilitado;

			this.modal_datos_visible = true;
		},
		Nuevo() {
			this.Resetear();
			this.frmDatosUsuario.modo = "NUEVO";
			this.title_modal = "NUEVO USUARIO";
			this.modal_datos_visible = true;
		},
		Resetear() {
			this.submited = false;

			this.frmDatosUsuario.id = null;
			this.frmDatosUsuario.dni = null;
			this.frmDatosUsuario.usuario = null;
			this.frmDatosUsuario.apellido_paterno = null;
			this.frmDatosUsuario.apellido_materno = null;
			this.frmDatosUsuario.nombres = null;
			this.frmDatosUsuario.agencia_id = 0;
			this.frmDatosUsuario.cargo_id = 0;
		},

		async Guardar() {
			let self = this;
			this.submited = true;
			if (this.v$.frmDatosUsuario.$invalid == true) {
				this.$swal.fire({
					icon: "error",
					title: "¡Ups!",
					text: "Hay uno o más campos vacíos, verifique.",
				});
				return false;
			}
			let data = new FormData();
			data.append("modo", this.frmDatosUsuario.modo);
			data.append("dni", this.frmDatosUsuario.dni);
			data.append("usuario", this.frmDatosUsuario.usuario);

			await axios
				.post(api_url + "/usu/gestion/verificar", data)
				.then(function (response) {
					let resultado = response.data;
					if (resultado == "INCORRECTO_D") {
						self.$swal.fire({
							icon: "error",
							title: "¡Ups!",
							text: "El DNI ingresado, ya está registrado, intente nuevamente.",
						});
						return false;
					} else if (resultado == "INCORRECTO_U") {
						self.$swal.fire({
							icon: "error",
							title: "¡Ups!",
							text: "El USUARIO ingresado, ya está registrado, intente nuevamente.",
						});
						return false;
					} else {
						self.$swal
							.fire({
								title: "¿Desea continuar?",
								confirmButtonText: "Si",
								showCancelButton: true,
								cancelButtonText: "No",
								allowOutsideClick: false,
								backdrop: true,
							})
							.then((result) => {
								if (result.isConfirmed) {
									self.$swal.fire({
										title: "REGISTRANDO",
										showConfirmButton: false,
										allowOutsideClick: false,
										willOpen: async () => {
											self.$swal.showLoading();

											let data = new FormData();
											data.append(
												"frmDatosUsuario",
												JSON.stringify(self.frmDatosUsuario)
											);

											return await axios
												.post(api_url + "/usu/gestion/guardar", data)
												.then((response) => {
													console.log(response);
													self.submited = false;
													self.ListarRecursos();
													self.Cerrar("mdlDatosUsuario");

													return self.$swal.fire({
														icon: "success",
														title: "¡ÉXITO!",
														timer: 1200,
														showConfirmButton: false,
													});
												})
												.catch((error) => {
													self.$swal.showValidationMessage(
														`Ha ocurrido un error, comunicar a TI: ${error}`
													);
												});
										},
									});
								}
							});
					}
				});
		},

		async ModificarHabilitado(modo) {
			let self = this;

			let ruta = null;
			let mensaje = null;

			if (modo == "HABILITAR") {
				ruta = "/usu/gestion/habilitar";
				mensaje = "¿Desea deshabilitar este usuario?";
			} else if (modo == "DESHABILITAR") {
				ruta = "/usu/gestion/deshabilitar";
				mensaje = "¿Desea habilitar este usuario?";
			}
			this.$swal
				.fire({
					title: mensaje,
					confirmButtonText: "Si",
					showCancelButton: true,
					cancelButtonText: "No",
					allowOutsideClick: false,
					backdrop: true,
				})
				.then((result) => {
					if (result.isConfirmed) {
						self.$swal.fire({
							title: "REGISTRANDO",
							showConfirmButton: false,
							allowOutsideClick: false,
							willOpen: async () => {
								self.$swal.showLoading();

								let data = new FormData();
								data.append("usuario_id", this.frmDatosUsuario.id);

								return await axios
									.post(api_url + ruta, data)
									.then((response) => {
										console.log(response);
										self.submited = false;
										self.ListarRecursos();
										self.Cerrar("mdlDatosUsuario");

										return self.$swal.fire({
											icon: "success",
											title: "¡ÉXITO!",
											timer: 1200,
											showConfirmButton: false,
										});
									})
									.catch((error) => {
										self.$swal.showValidationMessage(
											`Ha ocurrido un error, comunicar a TI: ${error}`
										);
									});
							},
						});
					}
				});
		},

		async ModificarClave(item) {
			this.submited = false;
			this.frmDatosClave.usuario_id = item.id;
			this.frmDatosClave.dni = item.dni;
			this.frmDatosClave.usuario = item.usuario;

			this.modal_clave_visible = true;
		},

		async GuardarClave() {
			let self = this;
			this.submited = true;

			if (this.v$.frmDatosClave.$invalid) {
				this.$swal.fire({
					icon: "error",
					title: "¡Ups!",
					text: "Hay uno o más campos vacíos, verifique.",
				});
				return false;
			}

			if (this.frmDatosClave.clave_nueva != this.frmDatosClave.clave_repetida) {
				this.$swal.fire({
					icon: "error",
					title: "¡Ups!",
					text: "La clave no coincide, revise por favor.",
				});
				return false;
			}

			this.$swal
				.fire({
					title: "¿Desea continuar?",
					confirmButtonText: "Si",
					showCancelButton: true,
					cancelButtonText: "No",
					allowOutsideClick: false,
					backdrop: true,
				})
				.then((result) => {
					if (result.isConfirmed) {
						let data = new FormData();
						data.append("frmDatosClave", JSON.stringify(this.frmDatosClave));

						self.$swal.fire({
							title: "REGISTRANDO",
							showConfirmButton: false,
							allowOutsideClick: false,
							willOpen: async () => {
								self.$swal.showLoading();

								return await axios
									.post(api_url + "/usu/gestion/cambiar_clave", data)
									.then((response) => {
										console.log(response);
										self.submited = false;
										self.ListarRecursos();
										self.Cerrar("mdlCambiarClave");

										return self.$swal.fire({
											icon: "success",
											title: "¡ÉXITO!",
											timer: 1200,
											showConfirmButton: false,
										});
									})
									.catch((error) => {
										self.$swal.showValidationMessage(
											`Ha ocurrido un error, comunicar a TI: ${error}`
										);
									});
							},
						});
					}
				});
		},
	},
};
</script>

<style lang="scss">
.slot-usuarios-gestion {
	width: 70% !important;
	margin-left: 15% !important;
}

.mdlDatosUsuario {
	width: 50%;
}
.mdlCambiarClave {
	width: 30%;
}

@media (max-width: 992px) {
	.slot-usuarios-gestion {
		width: 80% !important;
		margin-left: 10% !important;
	}

	.mdlDatosUsuario {
		width: 40%;
	}
	.mdlCambiarClave {
		width: 40%;
	}
}

@media (max-width: 500px) {
	.slot-usuarios-gestion {
		width: 98% !important;
		margin-left: 1% !important;
	}

	.mdlDatosUsuario {
		width: 80%;
	}
	.mdlCambiarClave {
		width: 80%;
	}
}
</style>
