<template>
	<div>
		<HeaderNav />
		<div class="main-content">
			<div class="layout-px-spacing dash_1 slot-mantenimiento-permisos">
				<div class="row layout-top-spacing">
					<div class="layout-spacing">
						<div class="card component-card_1">
							<headerClose :title="'LISTA DE PERMISOS'"></headerClose>
							<h5 class="card-title">LISTA DE RESULTADOS</h5>
							<div class="card-body">
								<div class="row mb-2 col-12">
									<div class="col-md-6 col-9">
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
									:value="permisos"
									:scrollable="true"
									scrollHeight="400px"
									scrollDirection="both"
									:paginator="true"
									:rows="20"
									:filters="filters"
									paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport"
									currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords} registro(s)"
								>
									<Column
										class="align-center"
										field="editar"
										header="EDITAR"
										style="width: 70px !important"
									>
										<template #body="{ data }">
											<button
												class="btn btn-main-2 btn-sm rounded-pill"
												@click="Editar(data)"
											>
												<i class="pi pi-pencil"></i>
											</button>
										</template>
									</Column>
									<Column
										class="align-center"
										field="modulo"
										header="MÓDULO"
										style="width: 200px !important"
									>
										<template #body="{ data }">
											{{ data.modulo }}
										</template>
									</Column>
									<Column
										class="align-center"
										field="submodulo"
										header="SUBMÓDULO"
										style="width: 200px !important"
									>
										<template #body="{ data }">
											{{ data.submodulo }}
										</template>
									</Column>
								</DataTable>
							</div>
						</div>
					</div>
				</div>
			</div>

			<Dialog
				class="mdlDatosCargo"
				:visible="modal_visible"
				:modal="true"
				@update:visible="Cerrar"
				:header="title_modal"
			>
				<div class="row col-md-12 col-12">
					<div class="col-md-12">
						<div class="form-check">
							<input
								class="form-check-input"
								type="radio"
								id="rdbModuloExistente"
								value="MODULO_EXISTENTE"
								name="tipo_modulo"
								v-model="frmDatosPermiso.tipo_modulo"
							/>
							<label
								class="form-check-label label-title"
								for="rdbModuloExistente"
							>
								MÓDULO EXISTENTE
							</label>
						</div>
						<select
							class="form-select"
							v-model="frmDatosPermiso.modulo_existente"
							v-if="frmDatosPermiso.tipo_modulo == 'MODULO_EXISTENTE'"
							:class="[
								submited
									? frmDatosPermiso.tipo_modulo == 'MODULO_EXISTENTE'
										? !v$.frmDatosPermiso.modulo_existente.$invalid
											? 'is-valid'
											: 'is-invalid'
										: ''
									: '',
							]"
						>
							<option :value="0" disabled>Seleccione...</option>
							<option
								v-for="(item, index) in modulos"
								:key="index"
								:value="item.modulo"
							>
								{{ item.modulo }}
							</option>
						</select>
					</div>

					<div class="col-md-12">
						<div class="form-check">
							<input
								class="form-check-input"
								type="radio"
								id="rdbModuloNuevo"
								value="MODULO_NUEVO"
								name="tipo_modulo"
								v-model="frmDatosPermiso.tipo_modulo"
							/>
							<label class="form-check-label label-title" for="rdbModuloNuevo">
								MÓDULO NUEVO
							</label>
						</div>
						<input
							type="text"
							class="form-control mayus"
							v-model="frmDatosPermiso.modulo_nuevo"
							v-if="frmDatosPermiso.tipo_modulo == 'MODULO_NUEVO'"
							:class="[
								submited
									? frmDatosPermiso.tipo_modulo == 'MODULO_NUEVO'
										? !v$.frmDatosPermiso.modulo_nuevo.$invalid
											? 'is-valid'
											: 'is-invalid'
										: ''
									: '',
							]"
						/>
					</div>
					<div class="form-group col-md-12">
						<label class="label-title">SUBMÓDULO</label>
						<input
							type="text"
							class="form-control mayus"
							v-model="frmDatosPermiso.submodulo"
							:class="[
								submited
									? !v$.frmDatosPermiso.submodulo.$invalid
										? 'is-valid'
										: 'is-invalid'
									: '',
							]"
						/>
					</div>
				</div>
				<hr />
				<div class="text-right">
					<button
						type="button"
						class="btn btn-main-1 btn-icon-split"
						@click="Guardar"
					>
						<i class="pi pi-save"></i>
						<span class="text">GUARDAR</span>
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

const api_url = import.meta.env.VITE_API_URL;
const noZero = (value) => value != 0;

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
			modulos: [],
			permisos: [],

			filters: {},

			submited: false,
			title_modal: "NUEVO PERMISO",
			modal_visible: false,

			frmDatosPermiso: {
				modo: "NUEVO",
				id: null,
				modulo: null,
				tipo_modulo: "MODULO_EXISTENTE",
				modulo_existente: 0,
				modulo_nuevo: null,
			},
		};
	},
	validations() {
		if (this.frmDatosPermiso.tipo_modulo == "MODULO_EXISTENTE") {
			return {
				frmDatosPermiso: {
					modulo_existente: { noZero },
					submodulo: { required },
				},
			};
		} else if (this.frmDatosPermiso.tipo_modulo == "MODULO_NUEVO") {
			return {
				frmDatosPermiso: {
					modulo_nuevo: { required },
					submodulo: { required },
				},
			};
		}
	},
	created() {
		this.filters = {
			global: { value: null, matchMode: FilterMatchMode.CONTAINS },
			modulo: { value: null, matchMode: FilterMatchMode.CONTAINS },
			submodulo: { value: null, matchMode: FilterMatchMode.CONTAINS },
		};
	},
	mounted() {
		this.ListarRecursos();
	},

	methods: {
		async ListarRecursos() {
			let self = this;
			return await axios
				.get(api_url + "/man/usu/permisos/listar_recursos")
				.then(function (response) {
					self.modulos = response.data.modulos;
					self.permisos = response.data.permisos;
				});
		},
		Cerrar() {
			this.modal_visible = false;
		},
		Editar(item) {
			this.submited = false;
			this.frmDatosPermiso.id = item.id;

			this.frmDatosPermiso.tipo_modulo = "MODULO_EXISTENTE";
			this.frmDatosPermiso.modulo_existente = item.modulo;
			this.frmDatosPermiso.submodulo = item.submodulo;
			this.frmDatosPermiso.modulo_nuevo = null;
			this.frmDatosPermiso.modo = "EDITAR";

			this.modal_visible = true;
		},
		Nuevo() {
			this.Resetear();
			this.modal_visible = true;
		},
		Resetear() {
			this.submited = false;
			this.frmDatosPermiso.id = null;
			this.frmDatosPermiso.tipo_modulo = "AREA_EXISTENTE";
			this.frmDatosPermiso.modulo_existente = 0;
			this.frmDatosPermiso.submodulo = null;
			this.frmDatosPermiso.modulo_nuevo = null;
			this.frmDatosPermiso.modo = "NUEVO";
		},
		async Guardar() {
			let self = this;
			this.submited = true;

			if (this.v$.frmDatosPermiso.$invalid) {
				this.$swal.fire({
					icon: "error",
					title: "¡Ups!",
					text: "Hay uno o más campos vacíos, verifique.",
				});
				return false;
			}

			let data = new FormData();
			data.append("frmDatosPermiso", JSON.stringify(this.frmDatosPermiso));

			await axios
				.post(api_url + "/man/usu/permisos/verificar", data)
				.then(function (response) {
					let resultado = response.data.resultado;
					if (resultado == "EXISTE") {
						self.$swal.fire({
							icon: "warning",
							title: "¡Ups!",
							text: "Esta información ya está registrada, intente nuevamente.",
						});
						return false;
					} else if (resultado == "NO_EXISTE") {
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
										title: "Registrando...",
										showConfirmButton: false,
										allowOutsideClick: false,
										willOpen: async () => {
											self.$swal.showLoading();

											return await axios
												.post(api_url + "/man/usu/permisos/guardar", data)
												.then((response) => {
													self.submited = false;
													self.ListarRecursos();
													self.Cerrar();

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
	},
};
</script>

<style lang="scss">
.slot-mantenimiento-permisos {
	width: 50% !important;
	margin-left: 25% !important;
}

.mdlDatosCargo {
	width: 30%;
}

@media (max-width: 992px) {
	.slot-mantenimiento-permisos {
		width: 80% !important;
		margin-left: 10% !important;
	}

	.mdlDatosCargo {
		width: 40%;
	}
}

@media (max-width: 400px) {
	.slot-mantenimiento-permisos {
		width: 98% !important;
		margin-left: 1% !important;
	}

	.mdlDatosCargo {
		width: 80%;
	}
}
</style>
