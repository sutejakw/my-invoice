<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
let form = ref({
    id: "",
});
let allCustomers = ref([]);
let customer_id = ref([]);
const showModal = ref(false);
const hideModal = ref(true);
let listProducts = ref([]);
const errors = ref("");

onMounted(async () => {
    getInvoice();
    getAllCustomers();
    getProducts();
});

const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});

const getInvoice = async () => {
    await axios.get(`/api/invoices/${props.id}`).then((response) => {
        form.value = response.data.data;
    });
};

const getAllCustomers = async () => {
    await axios.get("/api/customers").then((response) => {
        allCustomers.value = response.data.data;
    });
};

const deleteInvoiceItem = async (id, invoiceId, i) => {
    if (confirm("Do you really want to delete?")) {
        form.value.items.splice(i, 1);
        if (id != undefined && invoiceId != undefined) {
            await axios.delete(`/api/invoice-items/${id}/${invoiceId}`);
        }
    }
};

const getProducts = async () => {
    await axios.get("/api/products").then((response) => {
        listProducts.value = response.data.data;
    });
};

const addCart = (item) => {
    const itemCart = {
        product_id: item.id,
        item_code: item.item_code,
        description: item.description,
        unit_price: item.unit_price,
        quantity: 0,
    };

    form.value.items.push(itemCart);
    closeModal();
};

const openModal = () => {
    showModal.value = !showModal.value;
};

const closeModal = () => {
    showModal.value = !hideModal.value;
};

const subTotal = () => {
    let total = 0;
    if (form.value.items) {
        form.value.items.map((data) => {
            total = total + data.quantity * data.unit_price;
        });
    }

    return total;
};

const grandTotal = () => {
    if (form.value.items) {
        const discount = (form.value.discount / 100) * subTotal();
        return Math.ceil(subTotal() - discount);
    }
};

const onEdit = async (id) => {
    if (form.value.items.length >= 1) {
        let subtotal = 0;
        subtotal = subTotal();
        let grandtotal = 0;
        grandtotal = grandTotal();
        await axios
            .put(`/api/invoices/${form.value.id}`, {
                customer_id: form.value.customer.id,
                date: form.value.date,
                due_date: form.value.due_date,
                number: form.value.number,
                reference: form.value.reference,
                discount: form.value.discount,
                sub_total: subtotal,
                total: grandtotal,
                terms_and_conditions: form.value.terms_and_conditions,
                invoice_item: JSON.stringify(form.value.items),
            })
            .then(() => {
                form.value.items = [];
                router.push("/");
            })
            .catch((error) => {
                if (error.response.status === 422) {
                    Object.values(error.response.data.errors).forEach((val) => {
                        errors.value += `${val[0]} \n`;
                    });
                    alert(errors.value);
                    errors.value = "";
                }
            });
    }
};
</script>
<template>
    <div class="container">
        <div class="invoices">
            <div class="card__header">
                <div>
                    <h2 class="invoice__title">Edit Invoice</h2>
                </div>
                <div></div>
            </div>

            <div class="card__content">
                <div class="card__content--header">
                    <div>
                        <p class="my-1">Customer</p>
                        <select
                            name=""
                            id=""
                            class="input"
                            v-if="form.customer"
                            v-model="form.customer.id"
                        >
                            <option disabled>Select customer</option>
                            <option
                                v-for="customer in allCustomers"
                                :key="customer.id"
                                :value="customer.id"
                            >
                                {{ customer.fullname }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <p class="my-1">Date</p>
                        <input
                            id="date"
                            placeholder="dd-mm-yyyy"
                            type="date"
                            class="input"
                            v-model="form.date"
                        />
                        <!---->
                        <p class="my-1">Due Date</p>
                        <input
                            id="due_date"
                            type="date"
                            class="input"
                            v-model="form.due_date"
                        />
                    </div>
                    <div>
                        <p class="my-1">Numero</p>
                        <input
                            type="text"
                            class="input"
                            v-model="form.number"
                        />
                        <p class="my-1">Reference(Optional)</p>
                        <input
                            type="text"
                            class="input"
                            v-model="form.reference"
                        />
                    </div>
                </div>
                <br /><br />
                <div class="table">
                    <div class="table--heading2">
                        <p>Item Description</p>
                        <p>Unit Price</p>
                        <p>Qty</p>
                        <p>Total</p>
                        <p></p>
                    </div>

                    <!-- item 1 -->
                    <div
                        class="table--items2"
                        v-if="form.items"
                        v-for="(item, i) in form.items"
                        :key="item.id"
                    >
                        <p v-if="item.product">
                            #{{ item.product.item_code
                            }}{{ item.product.description }}
                        </p>
                        <p v-else>
                            #{{ item.item_code }} {{ item.description }}
                        </p>
                        <p>
                            <input
                                type="text"
                                class="input"
                                v-model="item.unit_price"
                            />
                        </p>
                        <p>
                            <input
                                type="text"
                                class="input"
                                v-model="item.quantity"
                            />
                        </p>
                        <p>$ {{ item.quantity * item.unit_price }}</p>
                        <p
                            style="color: red; font-size: 24px; cursor: pointer"
                            @click="deleteInvoiceItem(item.id, form.id, i)"
                        >
                            &times;
                        </p>
                    </div>
                    <div style="padding: 10px 30px !important">
                        <button
                            class="btn btn-sm btn__open--modal"
                            @click="openModal"
                        >
                            Add New Line
                        </button>
                    </div>
                </div>

                <div class="table__footer">
                    <div class="document-footer">
                        <p>Terms and Conditions</p>
                        <textarea
                            cols="50"
                            rows="7"
                            class="textarea"
                            v-model="form.terms_and_conditions"
                        ></textarea>
                    </div>
                    <div>
                        <div class="table__footer--subtotal">
                            <p>Sub Total</p>
                            <span>$ {{ subTotal() }}</span>
                        </div>
                        <div class="table__footer--discount">
                            <p>Discount</p>
                            <input
                                type="text"
                                class="input"
                                v-model="form.discount"
                            />
                        </div>
                        <div class="table__footer--total">
                            <p>Grand Total</p>
                            <span>$ {{ grandTotal() }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card__header" style="margin-top: 40px">
                <div></div>
                <div>
                    <a class="btn btn-secondary" @click="onEdit(form.id)">
                        Save
                    </a>
                </div>
            </div>
        </div>
        <!--==================== add modal items ====================-->
        <Teleport to="body">
            <div class="modal main__modal" :class="{ show: showModal }">
                <div class="modal__content">
                    <span
                        class="modal__close btn__close--modal"
                        @click="closeModal"
                        >×</span
                    >
                    <h3 class="modal__title">Add Item</h3>
                    <hr />
                    <br />
                    <div class="modal__items">
                        <ul style="list-style: none">
                            <li
                                v-for="(listProduct, i) in listProducts"
                                :key="listProduct.id"
                                style="
                                    display: grid;
                                    grid-template-columns: 30px 350px 15px;
                                    align-items: center;
                                    padding-bottom: 5px;
                                "
                            >
                                <p>{{ i + 1 }}</p>
                                <a href="#"
                                    >{{ listProduct.item_code }}
                                    {{ listProduct.description }}</a
                                >
                                <button
                                    @click="addCart(listProduct)"
                                    style="
                                        border: 1px solid #e0e0e0;
                                        width: 35px;
                                        height: 35px;
                                        cursor: pointer;
                                    "
                                >
                                    +
                                </button>
                            </li>
                        </ul>
                    </div>
                    <br />
                    <hr />
                    <div class="model__footer">
                        <button
                            class="btn btn-light mr-2 btn__close--modal"
                            @click="closeModal"
                        >
                            Cancel
                        </button>
                        <button class="btn btn-light btn__close--modal">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </Teleport>
    </div>
</template>
