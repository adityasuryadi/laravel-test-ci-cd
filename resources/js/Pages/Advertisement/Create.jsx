//import hook useState from react
import React, { useState, useEffect } from "react";
import DataTable from "react-data-table-component";

//import layout
import Layout from "./../../Layouts/Default";
import FilterComponent from "@/Layouts/FilterComponent";
import InputImage from "@/Components/InputImage";

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
            <div className="flex items-center justify-center h-48 mb-4 rounded bg-gray-50 dark:bg-gray-800">
                <div className="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                    <form className="space-y-6" action="#" method="POST">
                        <div>
                            <label
                                htmlFor="email"
                                className="block text-sm font-medium leading-6 text-gray-900"
                            >
                                Nama Iklan
                            </label>
                            <div className="mt-2">
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
                            </div>
                        </div>

                        <div>
                            <div className="flex items-center justify-between">
                                <label
                                    htmlFor="password"
                                    className="block text-sm font-medium leading-6 text-gray-900"
                                >
                                    Durasi Tampil Iklan
                                </label>
                                <div className="text-sm">
                                    <a
                                        href="#"
                                        className="font-semibold text-indigo-600 hover:text-indigo-500"
                                    ></a>
                                </div>
                            </div>
                            <div className="mt-2">
                                <input
                                    id="adsDuration"
                                    name="adsDuration"
                                    type="adsDuration"
                                    autoComplete="adsDuration"
                                    value={adsDuration}
                                    onChange={(e) =>
                                        setAdsDuration(e.target.value)
                                    }
                                    required
                                    className="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div>
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
                />
            </div>
            <div className="mt-2">
                <div>
                    <label
                        htmlFor="image"
                        className="block text-sm font-medium leading-6 text-gray-900"
                    >
                        Gambar Iklan
                    </label>
                </div>
                <InputImage setImage={changeImage}></InputImage>
            </div>

            <div>
                <button
                    type="submit"
                    onClick={storePost}
                    className="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    Create
                </button>
            </div>
        </Layout>
    );
}
