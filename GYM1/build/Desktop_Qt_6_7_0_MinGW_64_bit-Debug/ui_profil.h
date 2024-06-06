/********************************************************************************
** Form generated from reading UI file 'profil.ui'
**
** Created by: Qt User Interface Compiler version 6.7.0
**
** WARNING! All changes made in this file will be lost when recompiling UI file!
********************************************************************************/

#ifndef UI_PROFIL_H
#define UI_PROFIL_H

#include <QtCore/QVariant>
#include <QtWidgets/QApplication>
#include <QtWidgets/QDialog>
#include <QtWidgets/QGridLayout>
#include <QtWidgets/QLabel>
#include <QtWidgets/QWidget>

QT_BEGIN_NAMESPACE

class Ui_Profil
{
public:
    QLabel *label_4;
    QWidget *layoutWidget;
    QGridLayout *gridLayout;
    QLabel *label;
    QLabel *Nom;
    QLabel *label_2;
    QLabel *Prenom;
    QLabel *label_3;
    QLabel *Age;

    void setupUi(QDialog *Profil)
    {
        if (Profil->objectName().isEmpty())
            Profil->setObjectName("Profil");
        Profil->resize(378, 300);
        Profil->setStyleSheet(QString::fromUtf8("QWidget{background-color:white;}\n"
"QLineEdit{\n"
"background-color:orange}"));
        label_4 = new QLabel(Profil);
        label_4->setObjectName("label_4");
        label_4->setGeometry(QRect(250, 10, 81, 61));
        label_4->setStyleSheet(QString::fromUtf8("border-radius:50px;\n"
"background-color:black;"));
        layoutWidget = new QWidget(Profil);
        layoutWidget->setObjectName("layoutWidget");
        layoutWidget->setGeometry(QRect(50, 50, 101, 62));
        gridLayout = new QGridLayout(layoutWidget);
        gridLayout->setObjectName("gridLayout");
        gridLayout->setContentsMargins(0, 0, 0, 0);
        label = new QLabel(layoutWidget);
        label->setObjectName("label");

        gridLayout->addWidget(label, 0, 0, 1, 1);

        Nom = new QLabel(layoutWidget);
        Nom->setObjectName("Nom");

        gridLayout->addWidget(Nom, 0, 1, 1, 1);

        label_2 = new QLabel(layoutWidget);
        label_2->setObjectName("label_2");

        gridLayout->addWidget(label_2, 1, 0, 1, 1);

        Prenom = new QLabel(layoutWidget);
        Prenom->setObjectName("Prenom");

        gridLayout->addWidget(Prenom, 1, 1, 1, 1);

        label_3 = new QLabel(layoutWidget);
        label_3->setObjectName("label_3");

        gridLayout->addWidget(label_3, 2, 0, 1, 1);

        Age = new QLabel(layoutWidget);
        Age->setObjectName("Age");

        gridLayout->addWidget(Age, 2, 1, 1, 1);


        retranslateUi(Profil);

        QMetaObject::connectSlotsByName(Profil);
    } // setupUi

    void retranslateUi(QDialog *Profil)
    {
        Profil->setWindowTitle(QCoreApplication::translate("Profil", "Dialog", nullptr));
        label_4->setText(QCoreApplication::translate("Profil", "TextLabel", nullptr));
        label->setText(QCoreApplication::translate("Profil", "Nom:", nullptr));
        Nom->setText(QCoreApplication::translate("Profil", "TextLabel", nullptr));
        label_2->setText(QCoreApplication::translate("Profil", "Prenom:", nullptr));
        Prenom->setText(QCoreApplication::translate("Profil", "TextLabel", nullptr));
        label_3->setText(QCoreApplication::translate("Profil", "Age:", nullptr));
        Age->setText(QCoreApplication::translate("Profil", "TextLabel", nullptr));
    } // retranslateUi

};

namespace Ui {
    class Profil: public Ui_Profil {};
} // namespace Ui

QT_END_NAMESPACE

#endif // UI_PROFIL_H
