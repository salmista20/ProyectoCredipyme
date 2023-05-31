<template>
	<div>
		<HeaderNav />
		<div class="main-content">
			<div class="layout-px-spacing dash_1 slot-clientes-gestion">
				<div class="row layout-top-spacing">
					<div class="layout-spacing">
						<div class="card component-card_1">
							<HeaderClose :title="'LISTA DE CLIENTES'"></HeaderClose>
							<h5 class="card-title">LISTA DE RESULTADOS</h5>
							<div class="card-body">
								<div class="row mb-2 col-12">
									<div class="col-md-5 col-9">
										<div class="input-group">
											<span class="input-group-text">
												<i class="pi pi-search"></i>
											</span>
											<input
												v-model="texto_busqueda"
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
									:value="clientes"
									:scrollable="true"
									scrollHeight="450px"
									scrollDirection="both"
									:paginator="false"
									currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords} registro(s)"
								>
									<Column
										class="align-center"
										field="editar"
										header="EDITAR"
										style="min-width: 50px !important"
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
										field="apellido_paterno"
										header="APELLIDO_PATERNO"
										style="min-width: 120px !important"
									>
										<template #body="{ data }">
											{{ data.apellido_paterno }}
										</template>
									</Column>
									<Column
										field="apellido_materno"
										header="APELLIDO_MATERNO"
										style="min-width: 120px !important"
									>
										<template #body="{ data }">
											{{ data.apellido_materno }}
										</template>
									</Column>
									<Column
										field="nombres"
										header="NOMBRES"
										style="min-width: 120px !important"
									>
										<template #body="{ data }">
											{{ data.nombres }}
										</template>
									</Column>
									<Column
										field="dni"
										header="DNI"
										style="min-width: 100px !important"
									>
										<template #body="{ data }">
											{{ data.dni }}
										</template>
									</Column>
									<Column
										field="expediente"
										header="EXPEDIENTE"
										style="min-width: 100px !important"
									>
										<template #body="{ data }">
											{{ data.expediente }}
										</template>
									</Column>
									<Column
										field="asesor"
										header="ASESOR"
										style="min-width: 100px !important"
									>
										<template #body="{ data }">
											{{ data.asesor }}
										</template>
									</Column>
								</DataTable>
							</div>
						</div>
					</div>
				</div>
			</div>

			<MdlDatosCliente ref="mdlDatosCliente"></MdlDatosCliente>
		</div>
	</div>
</template>

<script>
// Libreria VUE-STORAGE
import { useStorage } from "vue3-storage";

// Componentes del proyecto
import HeaderNav from "@/components/HeaderNav.vue";
import HeaderClose from "@/components/HeaderClose.vue";
import MdlDatosCliente from "@/views/Clientes/Components/mdlDatosCliente.vue";

// Libreria PRIMEVUE - DATATABLE
import DataTable from "primevue/datatable";
import Column from "primevue/column";

const api_url = import.meta.env.VITE_API_URL;

export default {
	setup() {
		return { storage: useStorage() };
	},
	components: {
		HeaderNav,
		HeaderClose,
		MdlDatosCliente,

		DataTable,
		Column,
	},
	data() {
		return {
			clientes: [],
			texto_busqueda: null,
		};
	},
	computed: {
		agencias() {
			return this.storage.getStorageSync("agencias");
		},
	},

	methods: {
		async Buscar() {
			let self = this;
			let texto_busqueda = this.texto_busqueda;

			if (texto_busqueda && texto_busqueda.length >= 3) {
				return await axios
					.post(api_url + "/cli/gestion/buscar/" + texto_busqueda)
					.then(function (response) {
						self.clientes = response.data;
					});
			} else {
				self.clientes = [];
			}
		},

		Nuevo() {
			let mdlDatosCliente = this.$refs.mdlDatosCliente;

			mdlDatosCliente.modal_visible = true;
		},
		Editar() {},
	},
};
</script>

<style lang="scss">
.slot-clientes-gestion {
	width: 70% !important;
	margin-left: 15% !important;
}

@media (max-width: 992px) {
	.slot-clientes-gestion {
		width: 80% !important;
		margin-left: 10% !important;
	}
}

@media (max-width: 400px) {
	.slot-clientes-gestion {
		width: 98% !important;
		margin-left: 1% !important;
	}
}
</style>
