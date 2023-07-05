//import hook useState from react
import React, { useState, useEffect } from "react";
import Layout from "./../../Layouts/Default";
import "../../../css/custom.css";

//import inertia adapter
import { Link } from "@inertiajs/react";
export default function ViewAdvertisement({ advertisement }) {
    const [merchants, setMerchants] = useState([]);
    const changeMerchants = (merchants) => {
        setData("merchants", merchants);
    };

    useEffect(() => {
        fetch("https://api.antrique.com/list_merchant.php")
            .then((res) => res.json())
            .then(
                (result) => {
                    setMerchants(result.data);
                },
                (error) => {
                    setError(error);
                }
            );
    }, []);

    const merchantName = (merchant_id) => {
        let tmp = merchants.find(
            (merchants) =>
                parseInt(merchants.merchant_id) === parseInt(merchant_id)
        );
        return tmp.merchant_name;
    };
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
                                View {advertisement.name}
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div className="mx-auto">
                <div className="bg-white shadow-md rounded-lg dark:bg-gray-800 dark:border-gray-700">
                    <a href="#">
                        <img
                            src=""
                            className="rounded-t-lg p-8"
                            srcSet={`/storage/${advertisement.source_url}`}
                            alt=""
                        />
                    </a>
                    <div className="px-5 pb-5">
                        <a href="#">
                            <h3 className="text-gray-900 font-semibold text-xl tracking-tight dark:text-white">
                                {advertisement.name}
                            </h3>
                        </a>
                        <div className="flex items-center mt-2.5 mb-5">
                            <span className="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 ml-3">
                                5.0
                            </span>
                        </div>
                        <ul className="list-disc">
                            {merchants.length > 0 &&
                                advertisement.merchants.map((element) => (
                                    <li key={element}>
                                        {merchantName(element)}
                                    </li>
                                ))}
                        </ul>
                    </div>
                </div>
            </div>
        </Layout>
    );
}
