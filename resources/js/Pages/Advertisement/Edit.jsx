//import hook useState from react
import React, { useState, useEffect, useCallback } from "react";
import DataTable from "react-data-table-component";

//import layout
import Layout from "./../../Layouts/Default";
import FilterComponent from "@/Layouts/FilterComponent";
import InputImage from "@/Components/InputImage";
import "../../../css/custom.css";

//import inertia adapter
import { router, Link, useForm } from "@inertiajs/react";
import { transform } from "lodash";

export default function EditAdvertisement({ advertisement, errors }) {
    const { data, setData, put, processing, transform } = useForm({
        name: advertisement.name,
        duration: advertisement.duration,
        source_url: "/storage/" + advertisement.source_url,
        merchants: [],
        // merchant_displays:
    });

    const rowSelectCritera = (row) =>
        advertisement.merchants.includes(parseInt(row.merchant_id));

    //define state
    const [selectedRows, setSelectedRows] = useState([]);
    const [error, setError] = useState(null);
    const [isLoaded, setIsLoaded] = useState(false);
    const [merchants, setMerchants] = useState([]);
    // const [selectedMerchantId, setSelectedmerchantId] = React.useState();
    const [image, setImage] = useState(undefined);

    // transform((data) => ({
    //     ...data,
    //     merchants: selectedRows,
    // }));
    const tableCustomStyles = {
        headRow: {
            style: {
                backgroundColor: "#e7eef0",
            },
        },
        striped: {
            default: "red",
        },
    };

    const changeImage = (image) => {
        setData("source_url", image);
    };

    const changeMerchants = (merchants) => {
        setData("merchants", merchants);
    };

    const postAds = async (e) => {
        console.warn(selectedRows);
    };

    const handleRowSelected = useCallback(({ selectedRows }) => {
        // let x = selectedRows;
        // setSelectedRows((x) => [...x, selectedRows]);
        // setSelectedRows();
        // console.warn(selectedRows);
        // selectedRows = selectedRows;
        // setData("merchants", "test");
        setSelectedRows((rows) => {
            selectedRows;
        });
        data.merchants = selectedRows;
        // (data) => {
        //     setData((data) => ({ ...data, merchants: selectedRows }));
        // };

        // (selectedRows) =>
        // setData((selectedRows) => {
        //     selectedRows;
        // });
    }, []);

    useEffect(() => {
        fetch("https://api.antrique.com/list_merchant.php")
            .then((res) => res.json())
            .then(
                (result) => {
                    setIsLoaded(true);
                    setMerchants(result.data);
                    setPending(false);
                },
                (error) => {
                    setIsLoaded(true);
                    setError(error);
                }
            );
    }, []);

    const columns = [
        {
            name: "Merchant Id",
            id: "merchant_id",
            selector: (row) => row.merchant_id,
            omit: true,
        },
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
        put(
            "/advertisement/" + advertisement.id
            // , {
            //     onBefore: () => {
            //         setData("merchants", selectedRows);
            //         // console.warn("wkwkw");
            //     },
            // }
        );
    };

    const [pending, setPending] = React.useState(true);
    return (
        <Layout>
            <nav className="flex my-5" aria-label="Breadcrumb">
                <ol className="inline-flex items-center space-x-1 md:space-x-3">
                    <li className="inline-flex items-center">
                        <a
                            href="#"
                            className="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white"
                        >
                            <svg
                                aria-hidden="true"
                                className="w-4 h-4 mr-2"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div className="flex items-center">
                            <svg
                                aria-hidden="true"
                                className="w-6 h-6 text-gray-400"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fillRule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clipRule="evenodd"
                                ></path>
                            </svg>
                            <Link
                                href="/advertisement"
                                className="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white"
                            >
                                Advertisement
                            </Link>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div className="flex items-center">
                            <svg
                                aria-hidden="true"
                                className="w-6 h-6 text-gray-400"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fillRule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clipRule="evenodd"
                                ></path>
                            </svg>
                            <span className="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">
                                Create
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>

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
                            value={data.name}
                            onChange={(e) => setData("name", e.target.value)}
                            required
                            className="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                        {errors.name && (
                            <span className="text-sm text-red-600">
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
                            value={data.duration}
                            onChange={(e) =>
                                setData("duration", e.target.value)
                            }
                            required
                            className="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                        {errors.duration && (
                            <span className="text-sm text-red-600">
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
                        <InputImage
                            setImage={changeImage}
                            image={data.source_url}
                        ></InputImage>
                        {errors.image && (
                            <span className="text-sm text-red-600">
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
                            selectableRowSelected={rowSelectCritera}
                            persistTableHead
                            customStyles={tableCustomStyles}
                            progressPending={pending}
                        />
                        <span className="text-sm text-red-600">
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
        </Layout>
    );
}
