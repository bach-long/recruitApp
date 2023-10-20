import React from "react";
import {
  UserOutlined,
  FolderOutlined,
  FolderAddOutlined,
} from "@ant-design/icons";
import SiderLayout from "../../../layout/SiderLayout";
import { Routes, Route } from "react-router-dom";
import JobBookmark from "./JobBookmark";
import JobSubmitted from "./JobSubmitted";
import CV from "./CV";

const menu = [
  {
    label: "Hồ sơ",
    path: "",
    key: "",
    icon: <UserOutlined />,
  },
  {
    label: "Việc làm đã lưu",
    path: "/job-bookmark",
    key: "job-bookmark",
    icon: <FolderAddOutlined />,
  },
  {
    label: "Việc làm đã nộp",
    path: "/job-submitted",
    key: "job-submitted",
    icon: <FolderOutlined />,
  },
];
const Profile = () => {
  return (
    <SiderLayout menuProps={{ items: menu, layout: "profile" }}>
      <Routes>
        <Route path="/" element={<CV />} />
        <Route path="/job-bookmark" element={<JobBookmark />} />
        <Route path="/job-submitted" element={<JobSubmitted />} />
        {/* <Route path="/my-company" element={<MyCompany />} /> */}
      </Routes>
    </SiderLayout>
  );
};

export default Profile;
