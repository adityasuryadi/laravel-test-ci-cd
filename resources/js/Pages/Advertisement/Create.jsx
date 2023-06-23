//import hook useState from react
import React, { useState, useEffect } from "react";
import DataTable from "react-data-table-component";

//import layout
import Layout from "./../../Layouts/Default";
import FilterComponent from "@/Layouts/FilterComponent";
import InputImage from "@/Components/InputImage";
import "../../../css/custom.css";

//import inertia adapter
import { router } from "@inertiajs/react";

export default function CreatePost({ errors }) {
    //define state
    const [selectedRows, setSelectedRows] = React.useState([]);
    const [adsName, setAdsName] = useState("");
    const [adsDuration, setAdsDuration] = useState("");
    const [error, setError] = useState(null);
    const [isLoaded, setIsLoaded] = useState(false);
    const [merchants, setMerchants] = useState([]);
    const [selectedMerchantId, setSelectedmerchantId] = React.useState([]);
    const [image, setImage] = useState(undefined);

    const tableCustomStyles = {
        headRow: {
            style: {
                color: "#223336",
                backgroundColor: "#e7eef0",
            },
        },
        striped: {
            default: "red",
        },
    };

    const changeImage = (image) => {
        setImage(image);
    };

    const postAds = async (e) => {
        console.warn(selectedRows);
    };

    const handleRowSelected = React.useCallback((state) => {
        setSelectedRows(state.selectedRows);
        console.warn(state);
    }, []);

    useEffect(() => {
        fetch("https://api.antrique.com/list_merchant.php")
            .then((res) => res.json())
            .then(
                (result) => {
                    setIsLoaded(true);
                    setMerchants(result.data);
                },
                // Note: it's important to handle errors here
                // instead of a catch() block so that we don't swallow
                // exceptions from actual bugs in components.
                (error) => {
                    setIsLoaded(true);
                    setError(error);
                }
            );
    }, []);

    const columns = [
        {
            name: "Nama Merchant",
            id: "merchant_name",
            selector: (row) => row.merchant_name,
        },
    ];

    const [filterText, setFilterText] = React.useState("");
    const [resetPaginationToggle, setResetPaginationToggle] =
        React.useState(false);
    const filteredItems = merchants.filter(
        (item) =>
            item.merchant_name &&
            item.merchant_name.toLowerCase().includes(filterText.toLowerCase())
    );

    const subHeaderComponentMemo = React.useMemo(() => {
        const handleClear = () => {
            if (filterText) {
                setResetPaginationToggle(!resetPaginationToggle);
                setFilterText("");
            }
        };

        return (
            <FilterComponent
                onFilter={(e) => setFilterText(e.target.value)}
                onClear={handleClear}
                filterText={filterText}
            />
        );
    }, [filterText, resetPaginationToggle]);

    //function "storePost"
    const storePost = async (e) => {
        e.preventDefault();

        router.post("/advertisement", {
            name: adsName,
            duration: adsDuration,
            merchants: selectedRows,
            image: image,
        });
    };

    return (
        <Layout>
            {/* <div className="flex items-center justify-center h-48 mb-4 rounded bg-gray-50 dark:bg-gray-800">
                <div className="mt-10 sm:mx-auto sm:w-full sm:max-w-sm"> */}
            <form className="space-y-6" action="#" method="POST">
                <div className="flex flex-wrap -mx-2 space-y-4 md:space-y-0">
                    <div className="w-full px-2 md:w-2/3">
                        <label
                            htmlFor="email"
                            className={`block text-sm font-medium leading-6  ${
                                errors.name != null
                                    ? "text-red-600"
                                    : "text-gray-900"
                            }`}
                        >
                            Nama Iklan
                        </label>
                        <input
                            id="adsName"
                            name="adsName"
                            type="adsName"
                            autoComplete="adsName"
                            value={adsName}
                            onChange={(e) => setAdsName(e.target.value)}
                            required
                            className="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                        {errors.name && (
                            <span class="text-sm text-red-600">
                                {" "}
                                {errors.name}{" "}
                            </span>
                        )}
                    </div>

                    <div className="w-full px-2 md:w-1/3">
                        <label
                            htmlFor="adsDuration"
                            className={`block text-sm font-medium leading-6  ${
                                errors.name != null
                                    ? "text-red-600"
                                    : "text-gray-900"
                            }`}
                        >
                            Durasi Tampil Iklan
                        </label>
                        <div className="text-sm">
                            <a
                                href="#"
                                className="font-semibold text-indigo-600 hover:text-indigo-500"
                            ></a>
                        </div>
                        <input
                            id="adsDuration"
                            name="adsDuration"
                            type="adsDuration"
                            autoComplete="adsDuration"
                            value={adsDuration}
                            onChange={(e) => setAdsDuration(e.target.value)}
                            required
                            className="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                        {errors.duration && (
                            <span class="text-sm text-red-600">
                                {" "}
                                {errors.duration}{" "}
                            </span>
                        )}
                    </div>
                    <div className="w-full px-2">
                        <div>
                            <label
                                htmlFor="image"
                                className="block text-sm font-medium leading-6 text-gray-900"
                            >
                                Gambar Iklan
                            </label>
                        </div>
                        <InputImage setImage={changeImage}></InputImage>
                        {errors.image && (
                            <span class="text-sm text-red-600">
                                {" "}
                                {errors.image}{" "}
                            </span>
                        )}
                    </div>
                    <div className="w-full px-2">
                        <DataTable
                            fixedHeader
                            fixedHeaderScrollHeight="300px"
                            columns={columns}
                            pagination
                            data={filteredItems}
                            paginationResetDefaultPage={resetPaginationToggle} // optionally, a hook to reset pagination to page 1
                            subHeader
                            subHeaderComponent={subHeaderComponentMemo}
                            onSelectedRowsChange={handleRowSelected}
                            selectableRows
                            persistTableHead
                            customStyles={tableCustomStyles}
                        />
                        <span class="text-sm text-red-600">
                            {errors.merchants}
                        </span>
                    </div>

                    <div className="w-full px-2">
                        <button
                            type="submit"
                            onClick={storePost}
                            className="flex w-full mt-2 justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                            Create
                        </button>
                    </div>
                </div>
            </form>
            {/* </div>
            </div> */}
        </Layout>
    );
}
