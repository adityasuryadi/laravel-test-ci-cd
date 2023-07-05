import { Link } from "@inertiajs/react";
import React, { useState, useEffect } from "react";
import DataTable from "react-data-table-component";

//import layout
import Layout from "./../../Layouts/Default";

export default function Index({ advertisements }) {
    const columns = [
        {
            name: "Nama IKlan",
            id: "ads_name",
            selector: (row) => row.name,
        },
        {
            name: "Durasi IKlan",
            id: "ads_duration",
            selector: (row) => row.duration,
        },
        {
            cell: (row) => (
                <span
                    className={`text-xs font-semibold inline-block py-1 px-2 rounded-full text-white ${
                        row.is_active == "1" ? "bg-green-500" : "bg-red-500"
                    } last:mr-0 mr-1`}
                >
                    {row.is_active == "1" ? "Active" : "In Active"}
                </span>
            ),
            name: "Status IKlan",
            ignoreRowClick: true,
            allowOverflow: true,
            button: false,
            minWidth: "200px",
        },
        {
            cell: (row) => (
                <div className="inline-flex">
                    <Link
                        className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                        href={`advertisement/${row.id}`}
                    >
                        View
                    </Link>
                    &nbsp;
                    <Link
                        className="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                        href={`advertisement/${row.id}/edit`}
                    >
                        Edit
                    </Link>
                </div>
            ),
            ignoreRowClick: true,
            allowOverflow: true,
            button: true,
            minWidth: "200px",
        },
    ];
    const data = advertisements;
    return (
        <Layout>
            <nav className="flex my-5" aria-label="Breadcrumb">
                <ol className="inline-flex items-center space-x-1 md:space-x-3">
                    <li className="inline-flex items-center">
                        <Link
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
                        </Link>
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
                                Advertisement
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div className="w-full px-2 md:w-1/12">
                <Link
                    href="/advertisement/create"
                    className="flex mt-2 justify-center rounded bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    Add
                </Link>
            </div>
            <DataTable title="Advertisements" columns={columns} data={data} />
        </Layout>
    );
}
