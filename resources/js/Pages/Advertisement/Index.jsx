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
            cell: () => (
                <div>
                    <Link className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        View
                    </Link>
                    <Link className="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Edit
                    </Link>
                </div>
            ),
            ignoreRowClick: true,
            allowOverflow: true,
            button: true,
        },
    ];
    const data = advertisements;
    return (
        <Layout>
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
