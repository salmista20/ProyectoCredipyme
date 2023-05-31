<template>
	<div>
		<HeaderNav />
		<div class="main-content">
			<div class="layout-px-spacing dash_1 slot-mantenimiento-agencias">
				<div class="row layout-top-spacing">
					<div class="layout-spacing">
						<div class="card component-card_1">
							<headerClose :title="'LISTA DE AGENCIAS'"></headerClose>
							<h5 class="card-title">LISTA DE RESULTADOS</h5>
							<div class="card-body">
								<div class="row mb-2 col-12">
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
									:value="agencias"
									:scrollable="true"
									scrollHeight="450px"
									scrollDirection="both"
									:filters="filters"
									:globalFilterFields="['agencia']"
									:paginator="false"
									currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords} registro(s)"
								>
									<Column
										class="align-center"
										field="editar"
										header="EDITAR"
										style="width: 50px !important"
									>
										<template #body="{ data }">
											<div class="btn-group" role="group">
												<button
													class="btn btn-main-1 btn-sm"
													@click="Editar(data)"
												>
													<i class="pi pi-pencil"></i>
												</button>
											</div>
										</template>
									</Column>
									<Column
										class="align-center"
										field="agencia"
										header="AGENCIA"
										style="width: 200px !important"
									>
										<template #body="{ data }">
											{{ data.agencia }}
										</template>
									</Column>
									<Column
										class="align-center"
										field="direccion"
										header="DIRECCION"
										style="width: 200px !important"
									>
										<template #body="{ data }">
											{{ data.direccion }}
										</template>
									</Column>
								</DataTable>
							</div>
						</div>
					</div>
				</div>
			</div>

			<Dialog
				class="mdlDatosAgencia"
				:visible="modal_visible"
				:modal="true"
				@update:visible="Cerrar"
				:header="title_modal"
			>
				<div class="row">
					<div class="form-group">
						<label class="label-title">AGENCIA</label>
						<input
							type="text"
							class="form-control mayus"
							v-model="frmDatosAgencia.agencia"
							:class="[
								submited
									? v$.frmDatosAgencia.agencia.$invalid
										? 'is-invalid'
										: 'is-valid'
									: '',
							]"
						/>
					</div>
					<div class="form-group">
						<label class="label-title">DIRECCIÓN</label>
						<textarea
							class="form-control mayus"
							rows="2"
							v-model="frmDatosAgencia.direccion"
							:class="[
								submited
									? v$.frmDatosAgencia.direccion.$invalid
										? 'is-invalid'
										: 'is-valid'
									: '',
							]"
						></textarea>
					</div>
				</div>
				<hr />
				<div class="text-right">
					<button
						type="button"
						class="btn btn-main-1 btn-icon-split"
						@click="Guardar"
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
			agencias: [],
			filters: {},

			title_modal: null,
			modal_visible: false,
			submited: false,

			frmDatosAgencia: {
				modo: null,
				id: null,
				agencia: null,
				direccion: null,
			},
		};
	},
	validations: {
		frmDatosAgencia: {
			agencia: { required },
			direccion: { required },
		},
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
				.get(api_url + "/man/usu/agencias/listar_recursos")
				.then(function (response) {
					self.agencias = response.data.agencias;
				});
		},
		Cerrar() {
			this.modal_visible = false;
		},
		Editar(item) {
			this.title_modal = "EDITAR AGENCIA";
			this.frmDatosAgencia.modo = "EDITAR";

			this.frmDatosAgencia.id = item.id;
			this.frmDatosAgencia.agencia = item.agencia;
			this.frmDatosAgencia.direccion = item.direccion;

			this.modal_visible = true;
		},
		Nuevo() {
			this.Resetear();
			this.frmDatosAgencia.modo = "NUEVO";
			this.title_modal = "NUEVA AGENCIA";
			this.modal_visible = true;
		},
		Resetear() {
			this.submited = false;

			this.frmDatosAgencia.id = null;
			this.frmDatosAgencia.agencia = null;
			this.frmDatosAgencia.direccion = null;
		},
		async Guardar() {
			let self = this;
			this.submited = true;
			if (this.v$.frmDatosAgencia.$invalid == true) {
				Swal.fire({
					icon: "error",
					title: "¡Ups!",
					text: "Hay uno o más campos vacíos, verifique.",
				});
				return false;
			}
			let data = new FormData();
			data.append("frmDatosAgencia", JSON.stringify(this.frmDatosAgencia));

			await axios
				.post(api_url + "/man/usu/agencias/verificar", data)
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
										title: "REGISTRANDO",
										showConfirmButton: false,
										allowOutsideClick: false,
										willOpen: async () => {
											self.$swal.showLoading();

											return await axios
												.post(api_url + "/man/usu/agencias/guardar", data)
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
.slot-mantenimiento-agencias {
	width: 50% !important;
	margin-left: 25% !important;
}

.mdlDatosAgencia {
	width: 30%;
}

@media (max-width: 992px) {
	.slot-mantenimiento-agencias {
		width: 80% !important;
		margin-left: 10% !important;
	}

	.mdlDatosAgencia {
		width: 40%;
	}
}

@media (max-width: 400px) {
	.slot-mantenimiento-agencias {
		width: 98% !important;
		margin-left: 1% !important;
	}

	.mdlDatosAgencia {
		width: 80%;
	}
}
</style>
