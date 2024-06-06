/********************************************************************************
** Form generated from reading UI file 'login.ui'
**
** Created by: Qt User Interface Compiler version 6.7.1
**
** WARNING! All changes made in this file will be lost when recompiling UI file!
********************************************************************************/

#ifndef UI_LOGIN_H
#define UI_LOGIN_H

#include <QtCore/QVariant>
#include <QtWidgets/QApplication>
#include <QtWidgets/QGridLayout>
#include <QtWidgets/QLabel>
#include <QtWidgets/QLineEdit>
#include <QtWidgets/QPushButton>
#include <QtWidgets/QWidget>

QT_BEGIN_NAMESPACE

class Ui_Login
{
public:
    QPushButton *pushButton;
    QWidget *layoutWidget;
    QGridLayout *gridLayout;
    QLabel *label;
    QLineEdit *username;
    QLabel *label_2;
    QLineEdit *password;

    void setupUi(QWidget *Login)
    {
        if (Login->objectName().isEmpty())
            Login->setObjectName("Login");
        Login->resize(435, 248);
        Login->setStyleSheet(QString::fromUtf8("QWidget[content=true]{\n"
"background-color:white;\n"
"border:5px solid orange;\n"
"color:black;\n"
"}\n"
"QLabel{\n"
" color:black;\n"
"}\n"
"QPushButton{\n"
"background-color:orange;}\n"
"QMessageBox{\n"
"background-color:white;\n"
"}"));
        Login->setProperty("content", QVariant(true));
        pushButton = new QPushButton(Login);
        pushButton->setObjectName("pushButton");
        pushButton->setGeometry(QRect(230, 130, 121, 24));
        layoutWidget = new QWidget(Login);
        layoutWidget->setObjectName("layoutWidget");
        layoutWidget->setGeometry(QRect(70, 40, 281, 81));
        gridLayout = new QGridLayout(layoutWidget);
        gridLayout->setObjectName("gridLayout");
        gridLayout->setContentsMargins(0, 0, 0, 0);
        label = new QLabel(layoutWidget);
        label->setObjectName("label");

        gridLayout->addWidget(label, 0, 0, 1, 1);

        username = new QLineEdit(layoutWidget);
        username->setObjectName("username");

        gridLayout->addWidget(username, 0, 1, 1, 1);

        label_2 = new QLabel(layoutWidget);
        label_2->setObjectName("label_2");

        gridLayout->addWidget(label_2, 1, 0, 1, 1);

        password = new QLineEdit(layoutWidget);
        password->setObjectName("password");

        gridLayout->addWidget(password, 1, 1, 1, 1);


        retranslateUi(Login);

        QMetaObject::connectSlotsByName(Login);
    } // setupUi

    void retranslateUi(QWidget *Login)
    {
        Login->setWindowTitle(QCoreApplication::translate("Login", "Form", nullptr));
        pushButton->setText(QCoreApplication::translate("Login", "Login", nullptr));
        label->setText(QCoreApplication::translate("Login", "Login :", nullptr));
        label_2->setText(QCoreApplication::translate("Login", "Mdp :", nullptr));
    } // retranslateUi

};

namespace Ui {
    class Login: public Ui_Login {};
} // namespace Ui

QT_END_NAMESPACE

#endif // UI_LOGIN_H
