//import React
import React from "react";
import Sidebar from "./Sidebar";
function Layout({ children }) {
    return (
        <>
            <Sidebar></Sidebar>
            <div className="p-4 sm:ml-64 bg-slate-100">{children}</div>
        </>
    );
}

export default Layout;
